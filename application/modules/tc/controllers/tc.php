<?php

class tc extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('stats_model', 'stats');
		$this->load->model('history_model', 'his');
		$this->load->model('assembly_model', 'assmd');
		$this->load->model('home/user_model', 'user');
		$this->load->model('acc_model', 'acc');
		$this->load->model('news_model', 'nmd');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		if(empty($this->session->userdata('user_id'))){
			redirect('home/dangnhap');
		}
		$admins = explode(',', ADMINS);
		if(!in_array($this->session->userdata('user_id'), $admins)){
			show_404();
		}
	}
	public function test(){
		echo 'ádfdsf';
	}
	public function index($page = 1){
		// var_dump('sdsad');die;
		if(empty($this->session->userdata('user_id'))){
			redirect('home/dangnhap');
		}

		$data = array();
		$data['his'] = $this->his->get_all(max($page, 1));
		$this->load->view('header');
		
		if(in_array($this->session->userdata('user_id'),  explode(',', ADMINS))){
			$data['vao'] = $this->stats->count_user_credit(1)->tong;
			$data['tieu'] = $this->stats->count_user_credit(0)->tong;
			$data['new_user'] = $this->stats->count_new_user();
			$data['thue'] = $this->stats->count_history();
			$this->load->view("thongke", $data);
		}
		$this->load->view('main', $data);
		$this->load->view('footer');
	}

	public function reset_bxh(){
		$this->user->reset_bxh();
		$this->session->set_flashdata('success', 'Đã reset bảng xếp hạng. Số giờ tích lũy của các thành viên trong tháng đã về 0.');
		redirect('tc/config');
	}

	/* BEGIN OF TIME MANAGER ====================================================== */
	function time_lv(){
		$header['title'] = 'Danh sách khung giờ cho thuê';
		
		$data['time_lv'] = $this->acc->getTimeLv();
		$this->load->view('tc/header', $header);
		$this->load->view('tc/time_lv', $data);
		$this->load->view('tc/footer');
	}
	function time_add(){
		$header['title'] = 'Thêm khung giờ cho thuê';
		
		$this->form_validation->set_rules('time_name','required');
		$this->form_validation->set_rules('time_start','required');
		$this->form_validation->set_rules('time_end','required');
		if($this->form_validation->run() == FALSE){
			$this->load->view('tc/header', $header);
			$this->load->view('tc/time_add');
			$this->load->view('tc/footer');
		} else {
			$new_data['time_name'] = $this->form_validation->set_value('time_name');
			$new_data['time_start'] = date('H:i',strtotime( $this->form_validation->set_value('time_start') ) ) ;
			$new_data['time_end'] = date('H:i',strtotime( $this->form_validation->set_value('time_end') ) ) ;
			$this->acc->insertTime($new_data);
			$this->session->set_flashdata('success', 'Lưu thành công!');
			redirect('tc/time_lv');
		}
	}
	function time_edit($id){
		$data['time'] = $this->acc->getTimeLvDetail($id);

		if(!$data['time']){
			redirect('tc/time_lv');
		}

		$header['title'] = "Sửa thông tin khung giờ";
		$this->form_validation->set_rules('time_name','required');
		$this->form_validation->set_rules('time_start','required');
		$this->form_validation->set_rules('time_end','required');
		if($this->form_validation->run() == FALSE){
			$this->load->view('tc/header', $header);
			$this->load->view('tc/time_edit', $data);
			$this->load->view('tc/footer');
		} else {
			$new_data['time_name'] = $this->form_validation->set_value('time_name');
			$new_data['time_start'] = $this->form_validation->set_value('time_start');
			$new_data['time_end'] = $this->form_validation->set_value('time_end');
			$this->acc->updateTime($id, $new_data);
			$this->session->set_flashdata('success', 'Lưu thành công!');
			redirect('tc/time_edit/'.$acc_id.'');
		}

	}
	function time_del($id){
		$this->acc->delTime($id);
		$this->session->set_flashdata('success', 'Xóa nick thành công.');
		redirect('tc/time_lv');
	}
	/* END OF TIME MANAGER ====================================================== */

	public function tralai($h_id){
		$history = $this->his->get_history_by_h_id($h_id);
		if(!$history){
			$this->session->set_flashdata('error', 'Lịch sử lần thuê này không tồn tại hoặc đã bị xóa.');
			redirect('tc');
		}
		$last_hit = $this->his->get_history_by_acc_id($history->h_acc_id);
		if($last_hit->h_id != $history->h_id){
			$this->session->set_flashdata('error', 'Không thể hoàn tiền vì tài khoản này đã bị đặt trc chặn đầu (ID lịch sử: '.$last_hit->h_id.').');
			redirect('tc');
		} else {
			$this->his->del_history_by_h_id($history->h_id);
			$this->his->del_user_credit_log($history->h_c_id);
			$this->his->update_user_credit($history->h_user_id, $history->h_price);

			$acl = array(
				'acl_ad_id' => $this->session->userdata('user_id'),
				'acl_user_id' => $history->h_user_id,
				'acl_amount' => $history->h_price,
				'acl_note'	=> "Trả lại tiền theo yêu cầu của khách hàng: Hủy đặt trước tài khoản",
				'acl_time' => time(),
			);
			$this->his->save_admin_credit_log($acl);

			//Cập nhật số giờ thuê
			$user_data = $this->user->get_user_by_id($this->session->userdata('user_id'));
			$new_user_data = array(
				'user_sogio'	=> $user_data->user_sogio-($history->h_stop_time-$history->h_start_time)/60/60,
			);
			$this->user->user_update($user_data->user_id, $new_user_data);
			
			$this->session->set_flashdata('success', 'Hủy thành công đặt trc và đã trả lại '.number_format($history->h_price).'đ cho khách hàng!');
			redirect('tc');
		}
	}

	/* Assembly group */
	function ass($cat_id = null) {
		$data['assemblies'] = $this->assmd->get_assemblies($cat_id);
		$header['title'] = $data['title'] = 'Danh sách Nick Liên Minh';
		$header['active'] = 'ass';
		$this->load->view('tc/header', $header);
		$this->load->view('tc/ass', $data);
		$this->load->view('tc/footer');
	}

	function ass_add() {
		$this->form_validation->set_rules('ass_active', 'acvite', 'xss_clean');
		$this->form_validation->set_rules('ass_cat_id', 'ID', 'required|xss_clean');
		$this->form_validation->set_rules('ass_title', 'Tên', 'required|xss_clean');
		$this->form_validation->set_rules('ass_image', 'Link ảnh minh họa', 'xss_clean');
		$this->form_validation->set_rules('ass_github', 'Git hub', 'required|xss_clean');
		$this->form_validation->set_rules('ass_description', 'Nội dung', 'required|xss_clean');
		$this->form_validation->set_rules('ass_content', 'Nội dung', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$data['categories'] = $this->assmd->get_categories();
			$header['title'] = $data['title'] = "Thêm Nick";
			$header['active'] = 'ass';
			$this->load->view('tc/header', $header);
			$this->load->view('tc/ass_add', $data);
			$this->load->view('footer');
		} else {
			if(!empty($this->form_validation->set_value('ass_active')) &&  $this->form_validation->set_value('ass_active') == "on"){
				$new_data['ass_active'] = 1;
			} else {
				$new_data['ass_active'] = 0;
			}
			$new_data['ass_cat_id'] = $this->form_validation->set_value('ass_cat_id');
			$new_data['ass_title'] = $this->form_validation->set_value('ass_title');
			$new_data['ass_image'] = $this->form_validation->set_value('ass_image');
			$new_data['ass_github'] = $this->form_validation->set_value('ass_github');
			$new_data['ass_description'] = $this->form_validation->set_value('ass_description');
			$new_data['ass_content'] = $this->form_validation->set_value('ass_content');
			$inserted = $this->assmd->assembly_insert($new_data);
			$this->session->set_flashdata('success', 'Thêm Nick thành công.');
			redirect('tc/ass_edit/'.$inserted.'');
		}
	}

	function ass_edit($ass_id) {
		$data['assembly'] = $this->assmd->get_assembly($ass_id);
		if(!$data['assembly']) {redirect('tc/ass');}
		$this->form_validation->set_rules('ass_active', 'acvite', 'xss_clean');
		$this->form_validation->set_rules('ass_cat_id', 'Category ID', 'required|xss_clean');
		$this->form_validation->set_rules('ass_title', 'Tên', 'required|xss_clean');
		$this->form_validation->set_rules('ass_image', 'Link ảnh minh họa', 'xss_clean');
		$this->form_validation->set_rules('ass_github', 'Git hub', 'required|xss_clean');
		$this->form_validation->set_rules('ass_description', 'Nội dung', 'required|xss_clean');
		$this->form_validation->set_rules('ass_content', 'Nội dung', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$data['categories'] = $this->assmd->get_categories();
			$header['title'] = $data['title'] = "Sửa Nick";
			$header['active'] = 'ass';
			$this->load->view('tc/header', $header);
			$this->load->view('tc/ass_edit', $data);
			$this->load->view('tc/footer');
		} else {
			if(!empty($this->form_validation->set_value('ass_active')) &&  $this->form_validation->set_value('ass_active') == "on"){
				$new_data['ass_active'] = 1;
			} else {
				$new_data['ass_active'] = 0;
			}
			$new_data['ass_cat_id'] = $this->form_validation->set_value('ass_cat_id');
			$new_data['ass_title'] = $this->form_validation->set_value('ass_title');
			$new_data['ass_image'] = $this->form_validation->set_value('ass_image');
			$new_data['ass_github'] = $this->form_validation->set_value('ass_github');
			$new_data['ass_description'] = $this->form_validation->set_value('ass_description');
			$new_data['ass_content'] = $this->form_validation->set_value('ass_content');
			$this->assmd->assembly_update($ass_id, $new_data);
			$this->session->set_flashdata('success', 'Lưu nick thành công.');
			redirect('tc/ass_edit/'.$ass_id.'');
		}
	}

	function ass_del($ass_id) {
		$this->assmd->assembly_delete($ass_id);
		$this->session->set_flashdata('success', 'Xóa nick thành công.');
		redirect('tc/ass');
	}

	function ass_category($cat_id = null) {
		$data['categories'] = $this->assmd->get_categories($cat_id);
		$header['title'] = $data['title'] = 'Danh sách Rank';
		$header['active'] = 'ass_category';
		$this->load->view('tc/header', $header);
		$this->load->view('tc/ass_category', $data);
		$this->load->view('tc/footer');
	}

	function ass_category_add() {
		$this->form_validation->set_rules('cat_title', 'Tên', 'required|xss_clean');
		$this->form_validation->set_rules('cat_image', 'Link ảnh minh họa', 'xss_clean');
		$this->form_validation->set_rules('cat_content', 'Nội dung', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$header['title'] = $data['title'] = "Thêm rank";
			$header['active'] = 'ass_category';
			$this->load->view('tc/header', $header);
			$this->load->view('tc/ass_category_add', $data);
			$this->load->view('tc/footer');
		} else {

			$new_data['cat_title'] = $this->form_validation->set_value('cat_title');
			$new_data['cat_image'] = $this->form_validation->set_value('cat_image');
			$new_data['cat_content'] = $this->form_validation->set_value('cat_content');
			$this->assmd->category_insert($new_data);
			$this->session->set_flashdata('success', 'Thêm rank thành công.');
			redirect('tc/ass_category');
		}
	}

	function ass_category_edit($cat_id) {
		$data['category'] = $this->assmd->get_category($cat_id);
		if(!$data['category']) {redirect('tc/ass_category');}
		$this->form_validation->set_rules('cat_title', 'Tên', 'required|xss_clean');
		$this->form_validation->set_rules('cat_image', 'Link ảnh minh họa', 'xss_clean');
		$this->form_validation->set_rules('cat_content', 'Nội dung', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$header['title'] = $data['title'] = "Thêm rank";
			$header['active'] = 'ass_category';
			$this->load->view('tc/header', $header);
			$this->load->view('tc/ass_category_edit', $data);
			$this->load->view('footer');
		} else {

			$new_data['cat_title'] = $this->form_validation->set_value('cat_title');
			$new_data['cat_image'] = $this->form_validation->set_value('cat_image');
			$new_data['cat_content'] = $this->form_validation->set_value('cat_content');
			$this->assmd->category_update($cat_id, $new_data);
			$this->session->set_flashdata('success', 'Lưu rank thành công.');
			redirect('tc/ass_category');
		}
	}

	function champs(){
		$header['title'] = 'Danh sách tướng';
		$data['champs'] = $this->assmd->get_champs();
		$this->load->view('tc/header', $header);
		$this->load->view('tc/champs', $data);
		$this->load->view('footer');
	}

	function champ_edit($champ_id){
		$data['champ'] = $this->assmd->get_champ($champ_id);
		if(!$data['champ']) {redirect('tc/champs');}
		$this->form_validation->set_rules('champ_name', 'Tên', 'required|xss_clean');
		$this->form_validation->set_rules('champ_image', 'Link ảnh minh họa', 'xss_clean');
		$this->form_validation->set_rules('champ_ass_id', 'Assembly', 'xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$header['title'] = $data['title'] = "Sửa tướng";
			$header['active'] = 'champs';
			$data['assemblies'] = $this->assmd->get_assemblies(2, null, null, 1);
			$this->load->view('tc/header', $header);
			$this->load->view('tc/champ_edit', $data);
			$this->load->view('footer');
		} else {
			$new_data['champ_name'] = $this->form_validation->set_value('champ_name');
			$new_data['champ_image'] = $this->form_validation->set_value('champ_image');
			$new_data['champ_ass_id'] = $this->form_validation->set_value('champ_ass_id');
			$this->assmd->champ_update($champ_id, $new_data);
			$this->session->set_flashdata('success', 'Lưu thông tin tướng thành công.');
			redirect('tc/champs/#champ_'.($champ_id-1).'');
		}
	}
	/* Assembly group */
	
	public function acc(){
		$header['title'] = 'Danh sách tài khoản';
		
		$data['accs'] = $this->acc->get_all();
		$this->load->view('tc/header', $header);
		$this->load->view('tc/acc', $data);
		$this->load->view('tc/footer');
	}
	
	public function acc_edit($acc_id){
		
		$data['acc'] = $this->acc->get_acc_by_id($acc_id);
		if(!$data['acc']){
			redirect('tc/acc');
		}
		$header['title'] = "Sửa thông tin acc";
		$this->form_validation->set_rules('acc_pass','required');
		$this->form_validation->set_rules('acc_name','required');
		if($this->form_validation->run() == FALSE){
			$this->load->view('tc/header', $header);
			$this->load->view('tc/acc_edit', $data);
			$this->load->view('tc/footer');
		} else {
			$new_data['acc_pass'] = $this->form_validation->set_value('acc_pass');
			$new_data['acc_name'] = $this->form_validation->set_value('acc_name');
			$this->acc->update($acc_id, $new_data);
			$this->session->set_flashdata('success', 'Lưu thành công!');
			redirect('tc/acc_edit/'.$acc_id.'');
		}
	}
	
	public function acc_history($acc_id, $limit = 20){
		$header['title'] = "Lịch sử tài khoản";
		$data['histories'] = $this->his->get_all_history_by_acc_id($acc_id);
		$this->load->view('tc/header', $header);
		$this->load->view('tc/acc_history', $data);
		$this->load->view('tc/footer');
	}
	
	public function acc_add(){
		$header['title'] = "Thêm acc";
		$this->form_validation->set_rules('acc_pass','required');
		$this->form_validation->set_rules('acc_name','required');
		if($this->form_validation->run() == FALSE){
			$this->load->view('tc/header', $header);
			$this->load->view('tc/acc_add');
			$this->load->view('tc/footer');
		} else {
			$new_data['acc_pass'] = $this->form_validation->set_value('acc_pass');
			$new_data['acc_name'] = $this->form_validation->set_value('acc_name');
			$this->acc->insert($new_data);
			$this->session->set_flashdata('success', 'Lưu thành công!');
			redirect('tc/acc');
		}
	}
	
	public function acc_delete($acc_id){
		
		$this->acc->delete($acc_id);
		$this->session->set_flashdata('success', 'Xóa thành công!');
		redirect('tc/acc');
	}
	
	
		/* User group */
	public function user_search(){
		$this->form_validation->set_rules('user_name','','xss_clean');
		$this->form_validation->set_rules('user_id','','xss_clean');
		if($this->form_validation->run() == FALSE){
			redirect('tc');
		} else {
			$user_name = $this->form_validation->set_value('user_name');
			$user_id = $this->form_validation->set_value('user_id');
			if(!empty($user_name)) {
				$user = $this->user->get_user_by_login_name($user_name);
			} elseif(!empty($user_id)){
				$user = $this->user->get_user_by_id($user_id);
			} else {
				redirect('tc');
			}

			if(!$user){
				$this->session->set_flashdata('error', 'Không tìm thấy thành viên này.');
				redirect('tc');
			} else{
				redirect('tc/user_edit/'.$user->user_id.'');
			}
		}
	}
	
	public function fb(){
		$user = $this->user->get_user_by_login_name($_GET['u']);
		if(!$user){
			$this->session->set_flashdata('error', 'Không tìm thấy thành viên '.$_GET['u'].'.');
			redirect('tc');
		} else{
			redirect('tc/user_edit/'.$user->user_id.'');
		}
	}
			
	public function user_edit($user_id = 0){
		$user = $this->user->get_user_by_id($user_id);
		if(!$user){
			$this->session->set_flashdata('error', 'Không tìm thấy thành viên này.');
			redirect('tc');
		} else{
			$admins = explode(',', ADMINS);
			// if(in_array($user_id, $admins)){
				// $this->session->set_flashdata('error', 'Không thể sửa thông tin các thành viên trong danh sách đặc biệt này.');
				// redirect('tc');
			// }
			$this->form_validation->set_rules('user_password','','xss_clean');
			$this->form_validation->set_rules('user_credit','','numeric|required');
			$this->form_validation->set_rules('user_no','','numeric|required');
			if($this->form_validation->run() == FALSE){
				$data['user'] = $user;
				$data['logs'] = $this->user->get_user_credit_log($user_id);
				$header['title'] = $data['title'] = "Sửa thông tin thành viên";
				$header['active'] = 'home';
				$this->load->view('tc/header', $header);
				$this->load->view('tc/user_edit', $data);
				$this->load->view('footer');
			} else {
				$log = '';
				if(!empty($this->form_validation->set_value('user_password'))){
					$log .= ' Đổi mật khẩu.';
				}
				$tien_moi = $this->form_validation->set_value('user_credit');
				if($user->user_credit != $tien_moi){
					if($tien_moi - $user->user_credit > 0){
						$log .= ' Cộng '.number_format($tien_moi - $user->user_credit).' đ. Số tiền mới là '.number_format($tien_moi).'';
					} else {
						$log .= ' Trừ '.number_format(($user->user_credit - $tien_moi)).' đ. Số tiền mới là '.number_format($tien_moi).'';
					}
					//Lưu lịch sử giao dịch
					$new_credit_log = array(
						'c_user_id' => $user->user_id,
						'c_updown' => 1,
						'c_amount' => $tien_moi - $user->user_credit,
						'c_notice' => 'Được quản trị viên số '.$this->session->userdata('user_id').' cộng tiền',
						'c_time' => time(),
						'c_ip' => $this->input->ip_address()

					);
					$this->user->user_credit_insert($new_credit_log);
				}
				
				$no_moi = $this->form_validation->set_value('user_no');
				if($user->user_no != $no_moi){
					$log .= ' Ghi âm thêm '.number_format($no_moi - $user->user_no).' đ. Số nợ mới là '.number_format($no_moi).'';
					//Lưu lịch sử giao dịch
					$new_credit_log = array(
						'c_user_id' => $user->user_id,
						'c_updown' => 2,
						'c_amount' => $no_moi - $user->user_no,
						'c_notice' => 'Được quản trị viên số '.$this->session->userdata('user_id').' cập nhật số tiền nợ',
						'c_time' => time(),
						'c_ip' => $this->input->ip_address()

					);
					$this->user->user_credit_insert($new_credit_log);
				}
				
				//Lưu thông tin mới cho khách và ghi lịch sử Admin
				if($log != ''){
				$new_user_data = array(
					'user_credit' => $tien_moi,
					'user_no'	=> $no_moi,
				);
				if(!empty($this->form_validation->set_value('user_password'))){
					$new_user_data['user_password']	= $this->user->create_pass($this->form_validation->set_value('user_password'));
				}
				
				$this->user->user_update($user->user_id, $new_user_data);
				
				$acl = array(
					'acl_ad_id' => $this->session->userdata('user_id'),
					'acl_user_id' => $user->user_id,
					'acl_amount' => 0,
					'acl_note'	=> $log,
					'acl_time' => time(),
				);
				$this->his->save_admin_credit_log($acl);

				$this->session->set_flashdata('success', 'Cập nhật thông tin cho khách thành công. Thao tác được ghi lại với tên quản trị viên '.$this->session->userdata('user_name').'');
				redirect('tc/user_edit/'.$user_id.'');
				} else {
					redirect('tc/user_edit/'.$user_id.'');
				}
			}
			
		}
	}
	/* User group */

	public function config(){
		$this->load->model('iconfig_model', 'iconfig');
		if(!empty($this->input->post())){
			$data = $this->input->post();
			$this->iconfig->update($data);
			$this->session->set_flashdata('success', 'Lưu xong');
			redirect('tc/config');
		} else {
			$header['title'] = "Cấu hình";
			$data['configs'] = $this->iconfig->get();
			$this->load->view('tc/header', $header);
			$this->load->view('tc/config', $data);
			$this->load->view('tc/footer');
		}
	}
	
	/* news group */
	function news($nc_id = null) {
		$data['news'] = $this->nmd->get_news_by_category($nc_id);
		$header['title'] = $data['title'] = 'Danh sách news';
		$header['active'] = 'n';
		$this->load->view('tc/header', $header);
		$this->load->view('tc/news', $data);
		$this->load->view('tc/footer');
	}

	function n_add() {
		$this->form_validation->set_rules('n_active', 'acvite', 'xss_clean');
		$this->form_validation->set_rules('n_nc_id', 'ID', 'required|xss_clean');
		$this->form_validation->set_rules('n_title', 'Tên', 'required|xss_clean');
		$this->form_validation->set_rules('n_image', 'Link ảnh minh họa', 'xss_clean');
		$this->form_validation->set_rules('n_description', 'Nội dung', 'required|xss_clean');
		$this->form_validation->set_rules('n_content', 'Nội dung', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$data['categories'] = $this->nmd->get_categories();
			$header['title'] = $data['title'] = "Thêm news";
			$header['active'] = 'n';
			$this->load->view('tc/header', $header);
			$this->load->view('tc/news_add', $data);
			$this->load->view('footer');
		} else {
			if(!empty($this->form_validation->set_value('n_active')) &&  $this->form_validation->set_value('n_active') == "on"){
				$new_data['n_active'] = 1;
			} else {
				$new_data['n_active'] = 0;
			}
			$new_data['n_nc_id'] = $this->form_validation->set_value('n_nc_id');
			$new_data['n_title'] = $this->form_validation->set_value('n_title');
			$new_data['n_image'] = $this->form_validation->set_value('n_image');
			$new_data['n_description'] = $this->form_validation->set_value('n_description');
			$new_data['n_content'] = $this->form_validation->set_value('n_content');
			$new_data['n_time'] = $new_data['n_last_edit'] = time();
			$inserted = $this->nmd->news_insert($new_data);
			
			$acl = array(
				'acl_ad_id' => $this->session->userdata('user_id'),
				'acl_user_id' => $this->session->userdata('user_id'),
				'acl_amount' => 0,
				'acl_note'	=> "Thêm bài viết mới có ID ".$inserted."",
				'acl_time' => time(),
			);
			$this->his->save_admin_credit_log($acl);
			
			$this->session->set_flashdata('success', 'Thêm news thành công.');
			redirect('tc/n_edit/'.$inserted.'');
		}
	}

	function n_edit($n_id) {
		$data['news'] = $this->nmd->get_news($n_id);
		if(!$data['news']) {redirect('tc/n');}
		$this->form_validation->set_rules('n_active', 'acvite', 'xss_clean');
		$this->form_validation->set_rules('n_nc_id', 'Category ID', 'required|xss_clean');
		$this->form_validation->set_rules('n_title', 'Tên', 'required|xss_clean');
		$this->form_validation->set_rules('n_image', 'Link ảnh minh họa', 'xss_clean');
		$this->form_validation->set_rules('n_description', 'Nội dung', 'required|xss_clean');
		$this->form_validation->set_rules('n_content', 'Nội dung', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$data['categories'] = $this->nmd->get_categories();
			$header['title'] = $data['title'] = "Sửa news";
			$header['active'] = 'n';
			$this->load->view('tc/header', $header);
			$this->load->view('tc/news_edit', $data);
			$this->load->view('tc/footer');
		} else {
			if(!empty($this->form_validation->set_value('n_active')) &&  $this->form_validation->set_value('n_active') == "on"){
				$new_data['n_active'] = 1;
			} else {
				$new_data['n_active'] = 0;
			}
			$new_data['n_nc_id'] = $this->form_validation->set_value('n_nc_id');
			$new_data['n_title'] = $this->form_validation->set_value('n_title');
			$new_data['n_image'] = $this->form_validation->set_value('n_image');
			$new_data['n_description'] = $this->form_validation->set_value('n_description');
			$new_data['n_content'] = $this->form_validation->set_value('n_content');
			$new_data['n_last_edit'] = time();
			$this->nmd->news_update($n_id, $new_data);
			
			$acl = array(
				'acl_ad_id' => $this->session->userdata('user_id'),
				'acl_user_id' => $this->session->userdata('user_id'),
				'acl_amount' => 0,
				'acl_note'	=> "Sửa bài viết có ID ".$inserted."",
				'acl_time' => time(),
			);
			$this->his->save_admin_credit_log($acl);
			
			$this->session->set_flashdata('success', 'Lưu news thành công.');
			redirect('tc/n_edit/'.$n_id.'');
		}
	}

	function n_del($n_id) {
		$this->nmd->news_delete($n_id);
		$acl = array(
				'acl_ad_id' => $this->session->userdata('user_id'),
				'acl_user_id' => $this->session->userdata('user_id'),
				'acl_amount' => 0,
				'acl_note'	=> "Xóa bài viết ID ".$n_id."",
				'acl_time' => time(),
		);
		$this->his->save_admin_credit_log($acl);
		$this->session->set_flashdata('success', 'Xóa news thành công.');
		redirect('tc/news');
	}

	function n_category($nc_id = null) {
		$data['categories'] = $this->nmd->get_categories($nc_id);
		$header['title'] = $data['title'] = 'Danh sách Loại news';
		$header['active'] = 'n_category';
		$this->load->view('tc/header', $header);
		$this->load->view('tc/news_category', $data);
		$this->load->view('tc/footer');
	}

	function n_category_add() {
		$this->form_validation->set_rules('nc_title', 'Tên', 'required|xss_clean');
		$this->form_validation->set_rules('nc_image', 'Link ảnh minh họa', 'xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$header['title'] = $data['title'] = "Thêm Loại news";
			$header['active'] = 'n_category';
			$this->load->view('tc/header', $header);
			$this->load->view('tc/news_category_add', $data);
			$this->load->view('tc/footer');
		} else {

			$new_data['nc_title'] = $this->form_validation->set_value('nc_title');
			$new_data['nc_image'] = $this->form_validation->set_value('nc_image');
			$this->nmd->category_insert($new_data);
			$this->session->set_flashdata('success', 'Thêm Loại news thành công.');
			redirect('tc/n_category');
		}
	}

	function n_category_edit($nc_id) {
		$data['category'] = $this->nmd->get_category($nc_id);
		if(!$data['category']) {redirect('tc/n_category');}
		$this->form_validation->set_rules('nc_title', 'Tên', 'required|xss_clean');
		$this->form_validation->set_rules('nc_image', 'Link ảnh minh họa', 'xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$header['title'] = $data['title'] = "Thêm Loại news";
			$header['active'] = 'n_category';
			$this->load->view('tc/header', $header);
			$this->load->view('tc/news_category_edit', $data);
			$this->load->view('footer');
		} else {

			$new_data['nc_title'] = $this->form_validation->set_value('nc_title');
			$new_data['nc_image'] = $this->form_validation->set_value('nc_image');
			$this->nmd->category_update($nc_id, $new_data);
			$this->session->set_flashdata('success', 'Lưu Loại news thành công.');
			redirect('tc/n_category');
		}
	}

	/* news group */
}