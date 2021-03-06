<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
require_once ''.BASEPATH.'../application/libraries/Facebook/autoload.php';
class Home extends CI_Controller{
	private $fb;
	
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper('cookie');
		$this->load->model('User_model', 'user');
		$this->load->model('Acc_model', 'acc');
		$this->load->model('tc/news_model', 'nmd');
		$this->load->model('History_model', 'history');
		$this->load->model('gm_model', 'gm_model');
		$this->load->model('tc/Assembly_model', 'assmd');
		$this->load->model('iconfig_model', 'iconfig');
		$this->fb = new Facebook\Facebook([
		  'app_id' => FB_APP_ID,
		  'app_secret' => FB_S_KEY,
		  'default_graph_version' => 'v2.6',
		]);
		
		if(!empty($this->session->userdata('user_id'))){
			$user = $this->user->get_user_by_id($this->session->userdata('user_id'));
			$this->session->set_userdata($user);
		}	
	}
	
	public function index(){
		$data['cf'] = $this->iconfig->get();
		if(isset($_SERVER['HTTP_REFERER'])){
			$ref = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
			if($ref != 'toollm.com'){
				$this->session->set_userdata('ref', $ref);
			}
		} else {
			$this->session->set_userdata('ref', 'tructiep');
		}
		$header['title'] = $data['cf']->hometitle;
		if(!empty($this->session->userdata('user_id'))){
			$data['accs_dangthue'] = $this->history->get_acc_by_user_id($this->session->userdata('user_id'));
		}
		$data['tops'] = $this->user->bangxephang(12);
		$data['title'] = 'Danh sách tài khoản';

		// pr()

		$data['cacgois'] = $this->history->cacgoi();
		$data['cacgois_dattrc'] = $this->history->cacgoi_dattrc();
		$data['accs'] = $this->acc->danhsach();

		// pr($data['accs'],1);

		// pr($data['accs']);
		//Lay ra cac goi dang cho thue
		$pack = $this->acc->getPackAll();
		// pr($pack,1);
		$acc_ids = array();
		if(!empty($data['accs'])){
			foreach($data['accs'] AS $k => $acc){
				if(!in_array($k, $acc_ids)){
					$acc_ids[] = $k;
				}
			}
		}

		$ready_accs = $this->acc->get_acc_ready($acc_ids);

		$data['ready_accs'] = $this->filler_accs2($ready_accs, $pack );

		// pr($data['ready_accs'],1);
		
		// pr($data['accs'],1);
		
		$data['cf'] = $this->iconfig->get();
		
		$this->load->view('header', $header);
		
		$admins = explode(',', ADMINS);
		if($data['cf']->baotri == "ko"){
			$this->load->view('danhsach', $data);
		}
		
		$this->load->view('main', $data);
		$this->load->view('footer');
	}
	
	function filler_accs2($ready_accs, $pack){
		if(!$ready_accs || !$pack ) return false;
		$new_ready_accs = array();
		if( is_array($pack) ){
			foreach ($pack as $key => $value) {
				foreach ($ready_accs as $k => $vl) {
					if($vl->acc_id == $value->acc_id){
						$vl->time_lv = $value->time_start.' - ' .$value->time_end;
						$vl->price = $value->price;
						$vl->pack_id = $value->id;

						$new_ready_accs[] = $vl;
					}
				}
			}
		}else{

			foreach ($ready_accs as $k => $vl) {
				if($vl->acc_id == $pack->acc_id){
					$vl->time_lv = $pack->time_start.' - ' .$pack->time_end;
					$vl->price = $pack->price;
					$vl->pack_id = $pack->id;

					$new_ready_accs[] = $vl;
				}
			}

		}

		return $new_ready_accs;

		
	}

	function filler_accs($ready_accs, $pack_ids){
		if($ready_accs){
			$new_ready_accs = array();
			foreach ($ready_accs as $k => $vl) {
				if( in_array($vl->acc_id, $pack_ids) ){

					// $pack_detail = $this->acc->get_pack_by_id()
					$vl->time = 1000;
					$vl->price = 1000;

					$new_ready_accs[] = $vl;
				}
			}
			return $new_ready_accs;
		}
		return false;
	}
	public function dathue(){
		$data['cf'] = $this->iconfig->get();
		if(!empty($this->session->userdata('user_id'))){
			$data['accs_dangthue'] = $this->history->get_acc_by_user_id($this->session->userdata('user_id'));
		} else {
			redirect('home');
		}
		
		
		$header['title'] = 'Tài khoản đã thuê';
		$this->load->view('header', $header);
		
		$this->load->view('dathue', $data);
		$this->load->view('footer');
		
	}
	
	public function taitool(){
		$data['cf'] = $this->iconfig->get();
		$header['title'] = 'Hướng dẫn Cài đặt và sử dụng Tool';
		$this->load->view('header', $header);
		$this->load->view('taitool', $data);
		$this->load->view('footer');
	}
	
	
	public function test(){
		$this->load->view('header', $header);
		$this->load->view('test');
		$this->load->view('footer');
	}
	
	public function dangnhap(){
		if(!empty($this->session->userdata('user_id') ) ) {
			redirect('home');
		}  else {
			redirect('home/dangnhap_fb');
		}
		$header['title'] = 'Đăng nhập để thuê sub tool';
		$this->load->view('header', $header);
		$this->load->view('dangnhap'); 
		$this->load->view('footer');
	}
	
	public function dangnhap_fb(){
			$helper = $this->fb->getRedirectLoginHelper();
			$permissions = array(); // optional
			$loginUrl = $helper->getLoginUrl(site_url('home/login_callback'), $permissions);
			redirect($loginUrl);
	}
	
	public function dangnhap_tk(){
		if(!empty($this->session->userdata('user_id') ) ) {
			redirect('home');
		}
		$this->form_validation->set_rules('user_login','Tên đăng nhập', 'xss_clean|required|max_length[100]');
		$this->form_validation->set_rules('user_name','Tên hoặc biệt danh', 'xss_clean|max_length[100]');
		$this->form_validation->set_rules('user_password','Mật khẩu', 'xss_clean|required');
		if($this->form_validation->run() == FALSE){
			redirect('home/dangnhap');
		} else {
			$login = $this->form_validation->set_value('user_login');
			$pass = $this->form_validation->set_value('user_password');
			$name = $this->form_validation->set_value('user_name');
			if(empty($name)){
				$name = $login;
			}
			
			$user = $this->user->get_user_by_login_name($login);
			if(empty($user)){
				//Create new user
				$new_user = array(
					'user_login' => $login,
					'user_password' => $this->user->create_pass($pass),
					'user_name' => $name,
					'user_last_login' => time(),
					'user_credit' => 0,
					'user_fb_id' => '',
					'user_ref' => $this->session->userdata('ref'),
				);
				
				$user_id = $this->user->user_insert($new_user);
				$this->session->set_userdata('user_id', $user_id);
				$this->session->set_userdata('user_fb_id', $new_user['user_fb_id']);
				$this->session->set_userdata('user_last_login',  $new_user['user_last_login']);
				$this->session->set_userdata('user_name', $new_user['user_name']);
				$this->session->set_userdata('user_credit', $new_user['user_credit']);
				redirect('home');
			} else {
				//Check login
				//Neu dang nhap dung
				if($this->user->check_login($login, $pass)){
					$this->session->set_userdata('user_id', $user->user_id);
					$this->session->set_userdata('user_fb_id', $user->user_fb_id);
					$this->session->set_userdata('user_last_login',   $user->user_last_login);
					$this->session->set_userdata('user_name',  $user->user_name);
					$this->session->set_userdata('user_credit',  $user->user_credit);
					redirect('home');
				} else {
					$this->session->set_flashdata('login_notice', 'Mật khẩu không khớp với tài khoản');
					redirect('home/dangnhap');
				}
				
			}
			
		}
	}
	
	public function login_callback(){
		$helper = $this->fb->getRedirectLoginHelper();
		try {
		  $accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}

		if (isset($accessToken)) {
			$oAuth2Client = $this->fb->getOAuth2Client();
			// Lấy long_access_token
			$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken((string) $accessToken);
			
			// Đăng nhập thành công.
			$this->session->set_userdata('facebook_access_token', (string) $longLivedAccessToken);
			$this->fb->setDefaultAccessToken((string) $longLivedAccessToken);
			
			//Lấy thông tin
			try {
			  $response = $this->fb->get('/me');
			  $userNode = $response->getGraphUser();
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
			  // When Graph returns an error
			  echo 'Graph returned an error: ' . $e->getMessage();
			  exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			  // When validation fails or other local issues
			  echo 'Facebook SDK returned an error: ' . $e->getMessage();
			  exit;
			}
			
			
			$user = $this->user->get_user_by_fb_id($userNode->getId());
			if(!$user){
					
				$user_id = $this->user->user_insert(
				array(
				'user_id' => '',
				'user_login' => $userNode->getName(),
				'user_last_login' => time(),
				'user_fb_id'=> $userNode->getId(),
				'user_name'=> $userNode->getName(),
				'user_ref' => $this->session->userdata('ref'),
				));
				
				$this->session->set_userdata('user_id', $user_id);
				$this->session->set_userdata('user_fb_id', $userNode->getId());
				$this->session->set_userdata('user_last_login', time());
				$this->session->set_userdata('user_name', $userNode->getName());
				$this->session->set_userdata('user_credit', '0');
			} else {
				$new_data['user_last_login'] 	= time();
				$new_data['user_name'] 	= $userNode->getName();
				$this->user->user_update($user->user_id, $new_data);
				
				$user->user_name 		= $userNode->getName();
				$user->user_last_login 	= time();
				$this->session->set_userdata($user);
			}
			
			redirect('home');
			
		}
	}
	
	public function dangxuat(){
		$this->session->sess_destroy();
		redirect('home');
	}
	
	public function napthe_mega(){
		if( empty( $this->user->get_user_by_id($this->session->userdata('user_id') ) ) ){
			$this->session->set_userdata('backtome', site_url('napthe'));
			redirect('dangnhap');
		}
		$header['title'] = 'Nạp tiền vào tài khoản';
		$data['title'] = 'Nạp tiền vào tài khoản';
		$this->load->view('header', $header);
		$this->load->view('napthe', $data);
		$this->load->view('footer');
	}
	
	public function ajax_napthe(){
		if(empty($this->session->userdata('user_id'))){
			echo json_encode(array('code' => 1, 'msg' => "Vui lòng <a href=\"".site_url('home/dangnhap')."\">đăng nhập</a> trước khi nạp tiền"));
			exit();
		}

			//Megacard
			$ma_bao_mat = $this->input->post('ma_bao_mat', true);
			$send['cardSerial'] = $this->input->post('cardSerial', true);
			$send['cardPin'] = $this->input->post('cardPin', true);
			$send['telcoCode']  = $this->input->post('telcoCode', true);
			
			if(empty($ma_bao_mat)) {
				echo json_encode(array('code' => 1, 'msg' => "Thiếu mã bảo mật"));
				exit();
			}
			
			if(empty($send['telcoCode'])) {
				echo json_encode(array('code' => 1, 'msg' => "Bạn vui lòng chọn đây là loại thẻ nào nhé."));
				exit();
			}
			
			// check ma bao mat
			if(strtoupper ($ma_bao_mat) != strtoupper ($_SESSION['code_security'])) {
				echo json_encode(array('code' => 1, 'msg' => "Sai mã bảo mật"));
				exit();
			}
			
			if(empty($send['cardPin'])) {
				echo json_encode(array('code' => 1, 'msg' => "Thiếu mã thẻ"));
				exit();
			}
			if(empty($send['cardSerial'])) {
				echo json_encode(array('code' => 1, 'msg' => "Thiếu mã seri"));
				exit();
			}
			if(empty($send['telcoCode'])){
				echo json_encode(array('code' => 1, 'msg' => "Bạn cần chọn loại thẻ."));
				exit();
			}
			
			
			$mgconfig = array(
				'ws_url' => 'http://gachthe.megapay.net.vn/chargingApi',
				'partnerId' => '11418',
				'targetAcc' => 'chrapi',
				'password' => 'dce2fd'
			);
			
			require_once ''.BASEPATH.'../application/libraries/megacard.php';
			$service = new ChargingAPIServices($mgconfig);
			$response = $service->charging($send);
			
			$code = '-99';
			$info_card = null;
			if(!empty($response)){
				$code = $response['status'];
				if(isset($response['realAmount'])){
					$info_card = $response['realAmount'];
				}
				
			}else{
				echo json_encode(array('code' => 1, 'msg' => "Lỗi cấu hình website."));
				exit();
			}
			
			
			// nap the thanh cong
			if($code === '00' && $info_card >= 10000) {
				$user = $this->user->get_user_by_id($this->session->userdata('user_id'));
				$trano = '';
				if($user->user_no > 0){
					$trano = ' Đã xóa nợ '.$user->user_no.'đ';
				}
				$new_data['user_credit'] 	= $user->user_credit + $info_card - $user->user_no;
				$new_data['user_no'] =  0;
				$this->user->user_update($user->user_id, $new_data);
				$this->session->set_userdata('user_credit', $new_data['user_credit']);
				//Lưu lịch sử giao dịch
				$new_credit_log = array(
					'c_user_id' => $this->session->userdata('user_id'),
					'c_updown' => 1,
					'c_amount' => $info_card-$user->user_no,
					'c_notice' => 'Nạp tiền vào tài khoản. Tài khoản tăng từ '.number_format($user->user_credit).' lên '.number_format($new_data['user_credit']).'. '.$trano.'',
					'c_time' => time(),
					'c_ip' => $this->input->ip_address()
					
				);
				$this->user->user_credit_insert($new_credit_log);
					
				echo json_encode(array('code' => 0, 'msg' => "Nạp thẻ thành công mệnh giá " . $info_card.". Trở về trang chủ trong 3s.", "user_credit" => number_format($new_data['user_credit'])));
			}
			else {
				//get thong bao loi
				$loi = array(
					'01' => 'Đối tác không tồn tại.',
					'02' => 'Sai chữ ký.',
					'03' => 'Sai mật khẩu.',
					'04' => 'Sai IP.',
					'05' => 'Nhà cung cấp không tồn tại.',
					'06' => 'Đối tác chưa được cấu hình gạch thẻ với nhà cung cấp này.',
					'07' => 'Đối tác bị khóa gạch thẻ với nhà cung cấp này',
					'08' => 'Mã thẻ sai độ dài.',
					'09' => 'Mã thẻ sai định dạng.',
					'12' => 'Trùng mã giao dịch.',
					'11' => 'Hệ thống lỗi.',
					'14' => 'TransId không đúng định dạng.',
					'15' => 'Đã có một giao dịch thành công với serial này.',
					'16' => 'Giao dịch thất bại do các nguyên nhân khác.',
					'18' => 'Lỗi do trang web',
					'4' => 'Kiểm tra lại mã thẻ  (mã lỗi với thẻ Vinaphone).',
					'5' => 'Nhập sai mã thẻ quá 5 lần',
					'9' => 'Tạm thời khóa kênh nạp VMS do quá tải. Vui lòng thử lại sau 2-3 phút.',
					'10' => 'Hệ thống nhà cung cấp gặp lỗi. Vui lòng thử lại sau 2-3 phút.',
					'11' => 'Kết nối với nhà cung cấp tạm thời bị gián đoạn',
					'13' => 'Hệ thống tạm thời bận.',
					'-2' => 'Thẻ đã bị khóa.',
					'-3' => 'Thẻ đã hết hạn sử dụng.',
					'50' => 'Thẻ đã sử dụng hoặc không tồn tại.',
					'51' => 'Seri thẻ không đúng.',
					'52' => 'Mã thẻ và serial không khớp.',
					'53' => 'Mã thẻ và serial không khớp.',
					'55' => 'Card tạm thời bị block 24 h.',
					'59' => 'Mã thẻ chưa được kích hoạt.',
					'56' => 'TargetAccount tạm thời bị khóa do Charging sai nhiều lần. Chat với nhân viên để được hỗ trợ.',
					'63' => 'Không tìm thấy giao dịch này. Chat với nhân viên để được hỗ trợ.',
					'65' => 'Số lượng kết nối của partner quá mức cho phép.',
					'99' => 'Chưa nhận được kết quả trả về từ nhà cung cấp mã thẻ.',
				);
				if(isset($loi[$code])){
					echo json_encode(array('code' => 1, 'msg' => $loi[$code]));
				} else {
					echo json_encode(array('code' => 1, 'msg' => 'Có lỗi xảy ra, mã lỗi: '.$code.'. Bạn vui lòng F5 để thử lại 1 lần, nếu vẫn không được vui lòng chat với nhân viên hỗ trợ.'));
				}
				
			}
			//Het megacard
	}
	
	public function napthe(){
		if(empty($this->session->userdata('user_id'))){
			echo json_encode(array('code' => 1, 'msg' => "Vui lòng <a href=\"".site_url('home/dangnhap')."\">đăng nhập</a> trước khi nạp tiền"));
			exit();
		}
		
		$data['cf'] = $this->iconfig->get();
		if($data['cf']->napthe =="gamebank"){
			//Game bank
			$this->load->library('GB_API');
			// lay thong tin tu gamebank - muc tich hop website
			$merchant_id = 30096; // interger
			$api_user = "579f1533cb31c"; // string
			$api_password = "4cc169550746a62fca92e86db8c3ab0b"; // string

			// truyen du lieu the
			$pin = $_POST['cardPin']; // string
			$seri = $_POST['cardSerial']; // string
			$card_type = $_POST['telcoCode']; // interger
			$ma_bao_mat = $_POST['ma_bao_mat'];
			
			// check ma bao mat
			if(strtoupper($ma_bao_mat) != strtoupper($_SESSION['code_security'])) {
				echo json_encode(array('code' => 1, 'msg' => "Sai mã bảo mật "));
				exit();
			}
			
			$gb_api = new GB_API();
			$gb_api->setMerchantId($merchant_id);
			$gb_api->setApiUser($api_user);
			$gb_api->setApiPassword($api_password);
			$gb_api->setPin($pin);
			$gb_api->setSeri($seri);
			$gb_api->setCardType(intval($card_type));
			$gb_api->setNote("ID: ".$this->session->userdata('user_id'));
			$gb_api->cardCharging();
			$code = intval($gb_api->getCode());
			$info_card = intval($gb_api->getInfoCard());
			
			//Khuyen mai 1/6/2016
			//$info_card = $info_card*125/100;

			// nap the thanh cong
			if($code === 0 && $info_card >= 10000) {
				$user = $this->user->get_user_by_id($this->session->userdata('user_id'));

				$trano = '';
				if($user->user_no > 0){
					$trano = ' Đã xóa nợ '.$user->user_no.'đ';
				}
				$new_data['user_credit'] 	= $user->user_credit + $info_card - $user->user_no;
				$new_data['user_no'] =  0;
				$this->user->user_update($user->user_id, $new_data);
				
				$this->session->set_userdata('user_credit', $new_data['user_credit']);
				//Lưu lịch sử giao dịch
				$new_credit_log = array(
					'c_user_id' => $this->session->userdata('user_id'),
					'c_updown' => 1,
					'c_amount' => $info_card,
					'c_notice' => 'Nạp tiền vào tài khoản. Tài khoản tăng từ '.number_format($user->user_credit).' lên '.number_format($new_data['user_credit']).'. '.$trano.'',
					'c_time' => time(),
					
				);
				$this->user->user_credit_insert($new_credit_log);
					
				echo json_encode(array('code' => 0, 'msg' => "Nạp thẻ thành công mệnh giá " . $info_card.". Trở về trang chủ trong 3 giây.", "user_credit" => number_format($new_data['user_credit'])));
			}
			else {
				// get thong bao loi
				echo json_encode(array('code' => 1, 'msg' =>$gb_api->getMsg()));
			}
			
			//Het gamebank
		} else {
			//Megacard
			$ma_bao_mat = $this->input->post('ma_bao_mat', true);
			$send['cardSerial'] = $this->input->post('cardSerial', true);
			$send['cardPin'] = $this->input->post('cardPin', true);
			$send['telcoCode']  = $this->input->post('telcoCode', true);
			
			if(empty($ma_bao_mat)) {
				echo json_encode(array('code' => 1, 'msg' => "Thiếu mã bảo mật"));
				exit();
			}
			
			if(empty($send['telcoCode'])) {
				echo json_encode(array('code' => 1, 'msg' => "Bạn vui lòng chọn đây là loại thẻ nào nhé."));
				exit();
			}
			
			// check ma bao mat
			if(strtoupper ($ma_bao_mat) != strtoupper ($_SESSION['code_security'])) {
				echo json_encode(array('code' => 1, 'msg' => "Sai mã bảo mật"));
				exit();
			}
			
			if(empty($send['cardPin'])) {
				echo json_encode(array('code' => 1, 'msg' => "Thiếu mã thẻ"));
				exit();
			}
			if(empty($send['cardSerial'])) {
				echo json_encode(array('code' => 1, 'msg' => "Thiếu mã seri"));
				exit();
			}
			if(empty($send['telcoCode'])){
				echo json_encode(array('code' => 1, 'msg' => "Bạn cần chọn loại thẻ."));
				exit();
			}
			
			
			$mgconfig = array(
				'ws_url' => 'http://gachthe.megapay.net.vn/chargingApi',
				'partnerId' => '11418',
				'targetAcc' => 'chrapi',
				'password' => 'dce2fd'
			);
			
			require_once ''.BASEPATH.'../application/libraries/megacard.php';
			$service = new ChargingAPIServices($mgconfig);
			$response = $service->charging($send);
			
			$code = '-99';
			$info_card = null;
			if(!empty($response)){
				$code = $response['status'];
				if(isset($response['realAmount'])){
					$info_card = $response['realAmount'];
				}
				
			}else{
				echo json_encode(array('code' => 1, 'msg' => "Lỗi cấu hình website."));
				exit();
			}
			
			
			// nap the thanh cong
			if($code === '00' && $info_card >= 10000) {
				$user = $this->user->get_user_by_id($this->session->userdata('user_id'));
				$trano = '';
				if($user->user_no > 0){
					$trano = ' Đã xóa nợ '.$user->user_no.'đ';
				}
				$new_data['user_credit'] 	= $user->user_credit + $info_card - $user->user_no;
				$new_data['user_no'] =  0;
				$this->user->user_update($user->user_id, $new_data);
				$this->session->set_userdata('user_credit', $new_data['user_credit']);
				//Lưu lịch sử giao dịch
				$new_credit_log = array(
					'c_user_id' => $this->session->userdata('user_id'),
					'c_updown' => 1,
					'c_amount' => $info_card-$user->user_no,
					'c_notice' => 'Nạp tiền vào tài khoản. Tài khoản tăng từ '.number_format($user->user_credit).' lên '.number_format($new_data['user_credit']).'. '.$trano.'',
					'c_time' => time(),
					'c_ip' => $this->input->ip_address()
					
				);
				$this->user->user_credit_insert($new_credit_log);
					
				echo json_encode(array('code' => 0, 'msg' => "Nạp thẻ thành công mệnh giá " . $info_card.". Trở về trang chủ trong 3 giây.", "user_credit" => number_format($new_data['user_credit'])));
			}
			else {
				//get thong bao loi
				$loi = array(
					'01' => 'Đối tác không tồn tại.',
					'02' => 'Sai chữ ký.',
					'03' => 'Sai mật khẩu.',
					'04' => 'Sai IP.',
					'05' => 'Nhà cung cấp không tồn tại.',
					'06' => 'Đối tác chưa được cấu hình gạch thẻ với nhà cung cấp này.',
					'07' => 'Đối tác bị khóa gạch thẻ với nhà cung cấp này',
					'08' => 'Mã thẻ sai độ dài.',
					'09' => 'Mã thẻ sai định dạng.',
					'12' => 'Trùng mã giao dịch.',
					'11' => 'Hệ thống lỗi.',
					'14' => 'TransId không đúng định dạng.',
					'15' => 'Đã có một giao dịch thành công với serial này.',
					'16' => 'Giao dịch thất bại do các nguyên nhân khác.',
					'18' => 'Lỗi do trang web',
					'4' => 'Kiểm tra lại mã thẻ  (mã lỗi với thẻ Vinaphone).',
					'5' => 'Nhập sai mã thẻ quá 5 lần',
					'9' => 'Tạm thời khóa kênh nạp VMS do quá tải. Vui lòng thử lại sau 2-3 phút.',
					'10' => 'Hệ thống nhà cung cấp gặp lỗi. Vui lòng thử lại sau 2-3 phút.',
					'11' => 'Kết nối với nhà cung cấp tạm thời bị gián đoạn',
					'13' => 'Hệ thống tạm thời bận.',
					'-2' => 'Thẻ đã bị khóa.',
					'-3' => 'Thẻ đã hết hạn sử dụng.',
					'50' => 'Thẻ đã sử dụng hoặc không tồn tại.',
					'51' => 'Seri thẻ không đúng.',
					'52' => 'Mã thẻ và serial không khớp.',
					'53' => 'Mã thẻ và serial không khớp.',
					'55' => 'Card tạm thời bị block 24 h.',
					'59' => 'Mã thẻ chưa được kích hoạt.',
					'56' => 'TargetAccount tạm thời bị khóa do Charging sai nhiều lần. Chat với nhân viên để được hỗ trợ.',
					'63' => 'Không tìm thấy giao dịch này. Chat với nhân viên để được hỗ trợ.',
					'65' => 'Số lượng kết nối của partner quá mức cho phép.',
					'99' => 'Chưa nhận được kết quả trả về từ nhà cung cấp mã thẻ.',
				);
				if(isset($loi[$code])){
					echo json_encode(array('code' => 1, 'msg' => $loi[$code]));
				} else {
					echo json_encode(array('code' => 1, 'msg' => 'Có lỗi xảy ra, mã lỗi: '.$code.'. Bạn vui lòng F5 để thử lại 1 lần, nếu vẫn không được vui lòng chat với nhân viên hỗ trợ.'));
				}
				
			}
			//Het megacard
		}
		
	}
	
	public function taikhoan(){
		if( empty( $this->user->get_user_by_id($this->session->userdata('user_id') ) ) ){
			redirect('home');
		}
		
		$data['user'] = $this->user->get_user_by_id($this->session->userdata('user_id'));
		$data['logs'] = $this->user->get_user_credit_log($data['user']->user_id);
		
		$header['title'] = 'Lịch sử giao dịch';
		$data['title'] = 'Lịch sử giao dịch';
		if(!empty($this->session->userdata('user_id'))){
			$header['accs'] = $this->history->get_acc_by_user_id($this->session->userdata('user_id'));
		}
		$this->load->view('header', $header);
		$this->load->view('taikhoan', $data);
		$this->load->view('footer');
	}
	
	public function ungtien_GXTW(){
		$data['user'] = $this->user->get_user_by_id($this->session->userdata('user_id'));
		$data['logs'] = $this->user->get_user_credit_log($data['user']->user_id);
		if($data['user']->user_no > 0){
			$this->session->set_flashdata('error', 'Bạn đã ứng trước tiền 1 lần rồi và hiện chưa thanh toán khoản nợ đó vì vậy bạn không thể ứng trước thêm');
			redirect('home/taikhoan');
		}
		
		$tong = 0;
		if(!empty($data['logs'])){
			foreach($data['logs'] AS $log){
				if($log->c_updown == '1'){
					$tong += $log->c_amount;
				}
			}
		}
		
		
		$dieukien = 40000;
		$chovay = 3000;
		if($tong >= $dieukien){
			$data['user'] = $this->user->get_user_by_id($this->session->userdata('user_id'));
			$data['logs'] = $this->user->get_user_credit_log($data['user']->user_id);
			
			$new_data['user_credit'] 	= $data['user']->user_credit + $chovay ;
			$new_data['user_no'] = $chovay + 500 ; 
			//Tiền lãi.
			//Cập nhật thông tin user
			$this->user->user_update($data['user']->user_id, $new_data);
			
			//Lưu lịch sử giao dịch
			$new_credit_log = array(
				'c_user_id' => $this->session->userdata('user_id'),
				'c_updown' => 1,
				'c_amount' => $chovay,
				'c_notice' => 'Ứng trước '.number_format($chovay).' của hệ thống. Số tiền tăng từ '.number_format($data['user']->user_credit).' lên '.number_format($new_data['user_credit']).'. Lần nạp thẻ tiếp theo sẽ bị trừ '.number_format($new_data['user_no']).'đ',
				'c_time' => time(),
				'c_ip' => $this->input->ip_address()
				
			);
			$this->user->user_credit_insert($new_credit_log);
			
			$this->session->set_userdata('user_credit', $new_data['user_credit']);
			
			
			$this->session->set_flashdata('success', 'Bạn đã ứng trước thành công '.number_format($chovay).'đ và sẽ bị trừ '.number_format($new_data['user_no']).'đ tự động ở lần nạp tiền tiếp theo.');
			redirect('home/taikhoan');
		} else {
			$this->session->set_flashdata('error', 'Chúng tôi chỉ cho phép những thành viên đã nạp trên '.number_format($dieukien).'đ ứng trước tiền. Hiện tại bạn mới chỉ nạp '.number_format($tong).'đ nên chưa thể ứng trước.');
			redirect('home/taikhoan');
		}
	}
	
	public function thoigian(){
		$data['accs'] = $this->acc->danhsach();
		$acc_ids = array();
		if(!empty($data['accs'])){
			foreach($data['accs'] AS $k => $acc){
				if(!in_array($k, $acc_ids)){
					$acc_ids[] = $k;
				}
			}
		}
		$data['ready_accs'] = $this->acc->get_acc_ready($acc_ids);
		
		$header['title'] = 'Xem thời gian các tài khoản';
		$this->load->view('header', $header);
		$this->load->view('thoigian', $data);
		$this->load->view('footer');
	}
	
	
	public function giahan(){
		if(empty($this->session->userdata('user_id'))){
			$e['title'] = 'Lỗi';
			$e['mess'] = 'Vui lòng <a href="'.site_url('home/dangnhap').'">đăng nhập</a> trước khi thuê tài khoản';
			$e['stt'] = 'error';
			echo json_encode($e);
			exit();
		}
		$user_data = $this->user->get_user_by_id($this->session->userdata('user_id'));
		
		$this->form_validation->set_rules('h_id', 'History ID', 'required|xss_clean');
		$this->form_validation->set_rules('goi', 'Goi', 'required|xss_clean|numeric');
		if($this->form_validation->run() == FALSE){
			redirect('home');
		} else {
			$h_id = $this->form_validation->set_value('h_id');
			$goi = $this->form_validation->set_value('goi');
			$history = $this->history->get_history_by_h_id($h_id);
			if(!$history){ 
				$e['title'] = 'Lỗi';
				$e['mess'] = 'Sai thông tin yêu cầu';
				$e['stt'] = 'error';
				echo json_encode($e);
				exit();
			}
			$last_hit = $this->history->get_history_by_acc_id2($history->h_acc_id);
			if($last_hit->h_id != $history->h_id || $last_hit->h_user_id != $history->h_user_id ||time() + (BEFORE_TIME+5)*60 > $history->h_stop_time){
				$e['title'] = 'Không thể gia hạn';
				$e['mess'] = 'Tài khoản của bạn đã bị người khác đặt trước hoặc gia hạn quá muộn ( chỉ gia hạn được khi còn trên '.(BEFORE_TIME+5).' phút. Bạn có thể tải lại trang và ấn Thuê tài khoản khác';
				$e['stt'] = 'error';
				echo json_encode($e);
				exit();
			} else {
				
				$cacgoi = $this->history->cacgoi();
				if(!isset($cacgoi[$goi])){
					$e['title'] = 'Lỗi';
					$e['mess'] = 'Không thể thuê do không tồn tại gói bạn yêu cầu.';
					$e['stt'] = 'error';
					echo json_encode($e);
					exit();
				}
				$during = $cacgoi[$goi]['tgian']*60*60;
				$gia =  $cacgoi[$goi]['gia'];
				//Cộng thời gian, trừ tiền, ghi lịch sử
				if($user_data->user_credit < $gia)
				{
					$e['title'] = 'Quý khách không đủ tiền!';
					$e['mess'] = 'Xin lỗi bạn, số tiền cần trả là '.number_format($gia).'đ. Hiện tại bạn chỉ có '.number_format($user_data->user_credit).'đ. Vui lòng nạp thêm nhé!';
					$e['stt'] = 'error';
					echo json_encode($e);
					exit();
				} else {
					//Trừ tiền
					$new_user_data = array('user_credit' => $user_data->user_credit - $gia, 'user_sogio' => $user_data->user_sogio + $cacgoi[$goi]['tgian']);
					$this->user->user_update($user_data->user_id, $new_user_data);
					
					//Lưu lịch sử giao dịch
					$new_credit_log = array(
						'c_user_id' => $this->session->userdata('user_id'),
						'c_updown' => 0,
						'c_amount' => $gia,
						'c_notice' => 'Trừ tiền gia hạn tài khoản trong '.$cacgoi[$goi]['tgian'].' giờ. Tài khoản giảm từ '.number_format($user_data->user_credit).' xuống còn '.number_format($new_user_data['user_credit']).'.',
						'c_time' => time(),
						'c_ip' => $this->input->ip_address()

					);
					$c_id = $this->user->user_credit_insert($new_credit_log);


					$new_history = array(
						'h_stop_time' => $history->h_stop_time + $cacgoi[$goi]['tgian']*60*60 + AFTER_TIME*60,
						'h_price' =>  $history->h_price + $gia,
					);
					$this->history->h_update($h_id, $new_history);

				$e['title'] = 'Gia hạn thành công!';
				$e['mess'] = 'Tài khoản của bạn đã được tăng thêm '.$cacgoi[$goi]['tgian'].' giờ chơi';
				$e['stt'] = 'success';
				echo json_encode($e);
				exit();
				}
			}
			
			
		}
	}
	
	public function thuengay(){
		if(empty($this->session->userdata('user_id'))){
			$e['title'] = 'Lỗi';
			$e['mess'] = 'Vui lòng <a href="'.site_url('home/dangnhap').'">đăng nhập</a> trước khi thuê tài khoản';
			$e['stt'] = 'error';
			echo json_encode($e);
			exit();
		}
		

		$user_data = $this->user->get_user_by_id($this->session->userdata('user_id'));
		$this->form_validation->set_rules('acc_id', 'Acc ID', 'required|xss_clean');
		$this->form_validation->set_rules('goi', 'Goi', 'required|xss_clean|numeric');
		$this->form_validation->set_rules('tgian', 'Thoi gian thue', 'xss_clean|numeric');
		if($this->form_validation->run() == FALSE){
			redirect('home');
		} else {
		$acc = $this->acc->get_acc_by_id($this->form_validation->set_value('acc_id'));
		if(!$acc){
			$e['title'] = 'Lỗi';
			$e['mess'] = 'Không tồn tại tài khoản mà bạn vừa yêu cầu.';
			$e['stt'] = 'error';
			echo json_encode($e);
			exit();
		}
		if(empty($this->form_validation->set_value('tgian'))){
			//Thue ngay
			if($acc->acc_stt != "ROI" && $acc->acc_stt != "CHOHWID"){
				$e['title'] = 'Thất Bại!';
				$e['mess'] = 'Thật tiếc! tài khoản bạn định thuê đã bị bạn khác vừa ấn thuê nhanh hơn rồi. Vui lòng tải lại trang và thuê lại tài khoản khác nhé.';
				$e['stt'] = 'error';
				echo json_encode($e);
				exit();
			}
			
			$stt = 'DANGTHUE';
			
			
			$start = max($acc->acc_time_ready, time());
		} else {
			//Dat truoc
			$accs = $this->acc->danhsach();
			$acc_muon_dat = $accs[$acc->acc_id];
			$tgian = $this->form_validation->set_value('tgian');
			$stop_time = 0;
			foreach($acc_muon_dat AS $amd){
				if($amd->h_stop_time > $stop_time){
					$stop_time = $amd->h_stop_time;
				}
			}
			if($tgian != $stop_time){
				$e['title'] = 'Thất Bại!';
				$e['mess'] = 'Thật tiếc! tài khoản bạn định thuê đã bị bạn khác vừa ấn thuê nhanh hơn rồi. Vui lòng tải lại trang và thuê lại tài khoản khác nhé.';
				$e['stt'] = 'error';
				echo json_encode($e);
				exit();
			} else {
				$stt = 'DANGCHO';
				$start = $tgian + AFTER_TIME * 60 + $kmdem + $kmsang;
			}
		}

$hour = date("H", $start);
$kmdem = 0;
$noidungkm = "";
if($hour == 22 OR $hour == 23 OR ($hour >= 0 AND $hour < 4))
{
$kmdem = 2*60*60;
$noidungkm = "Khuyến mại thêm 2h do thuê đêm.";
}

$hour = date("H", $start);
$kmsang = 0;
$noidungkm = "";
if($hour >= 4 AND $hour < 10)
{
$kmsang = 1*60*60;
$noidungkm = "Khuyến mại thêm 1h do thuê sáng sớm.";
}


		 		
		$goi = $this->form_validation->set_value('goi');
		
		if($stt == 'DANGCHO'){
			$cacgoi = $this->history->cacgoi_dattrc();
		} else {
			$cacgoi = $this->history->cacgoi();
		}
		
		if(!isset($cacgoi[$goi])){
			$e['title'] = 'Lỗi';
			$e['mess'] = 'Không thể thuê do không tồn tại gói bạn yêu cầu.';
			$e['stt'] = 'error';
			echo json_encode($e);
			exit();
		}
		$during = $cacgoi[$goi]['tgian']*60*60;
		$gia =  $cacgoi[$goi]['gia'];

		if($user_data->user_credit < $gia)
		{
			$e['title'] = 'Quý khách không đủ tiền!';
			$e['mess'] = 'Xin lỗi bạn! số tiền cần trả là '.number_format($gia).'đ. Hiện tại bạn chỉ có '.number_format($user_data->user_credit).'đ. Vui lòng nạp thêm nhé!';
			$e['stt'] = 'error';
			echo json_encode($e);
			exit();
		} else {
			$update = array('acc_stt' => 'DANGTHUE');
			$this->acc->acc_update($acc->acc_id, $update);

			//Trừ tiền
			$new_user_data = array('user_credit' => $user_data->user_credit - $gia, 'user_sogio' => $user_data->user_sogio + $cacgoi[$goi]['tgian']);
			$this->user->user_update($user_data->user_id, $new_user_data);
			
			//Lưu lịch sử giao dịch
			$new_credit_log = array(
				'c_user_id' => $this->session->userdata('user_id'),
				'c_updown' => 0,
				'c_amount' => $gia,
				'c_notice' => 'Trừ tiền thuê tài khoản trong '.$cacgoi[$goi]['tgian'].' giờ. Thời gian bắt đầu sử dụng: '.date("H:i d/m", $start).'. Tài khoản giảm từ '.number_format($user_data->user_credit).' xuống còn '.number_format($new_user_data['user_credit']).'.',
				'c_time' => time(),
				'c_ip' => $this->input->ip_address()

			);
			$c_id = $this->user->user_credit_insert($new_credit_log);
			
			do{
				$h_key = $this->history->generateRandomString(28);
			} while($this->history->get_history_by_h_key($h_key)); 
			
			$new_history = array(
				'h_user_id' => $this->session->userdata('user_id'),
				'h_acc_id' => $acc->acc_id,
				'h_start_time' => $start,
				'h_stop_time' => $start+$during+$kmdem+$kmsang,
				'h_price' => $gia,
				'h_time' => time(),
				'h_c_id' => $c_id,
				'h_stt' => $stt,
				'h_key' => $h_key,
			);
			$this->history->h_insert($new_history);


			$e['title'] = 'Thành công';
			if($stt == 'DANGTHUE' AND $start <= time()) {
				// if($gia >= 10000){
					// $e['mess'] = 'Mã dự thưởng dự thưởng ngày '.date("d/m/Y", time()).' của bạn là '.substr($new_history['h_time'], -4).'. Tài khoản của bạn là: '.$acc->acc_name.'- mật khẩu: '.$acc->acc_pass.'.';
				// } else {
					//$e['mess'] = 'Thuê thành công. Tài khoản của bạn là: '.$acc->acc_name.'- Auth Key: '.$acc->acc_pass.'.';
					$e['mess'] = 'Thuê thành công! Hãy vào mục đã thuê để xem chi tiết.';
				//}
			} else {
				// if($gia >= 10000){
					// $e['mess'] = 'Đặt trước thành công! Bạn sẽ nhận được Key chơi được lúc '.date("H:i d/m/Y", $start).'. Mã dự thưởng dự thưởng ngày '.date("d/m/Y", time()).' của bạn là '.substr($new_history['h_time'], -4).'.';
				// } else {
					$e['mess'] = 'Đặt trước thành công! Bạn sẽ nhận được Key vào lúc '.date("H:i d/m/Y", $start).'.';
				//}
				
			}
			$e['stt'] = 'success';
			echo json_encode($e);
			exit();
		}
		}
	}

	public function thuengay_new(){
		if(empty($this->session->userdata('user_id'))){
			$e['title'] = 'Lỗi';
			$e['mess'] = 'Vui lòng <a href="'.site_url('home/dangnhap').'">đăng nhập</a> trước khi thuê tài khoản';
			$e['stt'] = 'error';
			echo json_encode($e);
			exit();
		}
		

		$user_data = $this->user->get_user_by_id($this->session->userdata('user_id'));
		$this->form_validation->set_rules('goi_id', 'Goi ID', 'required|xss_clean');
		$this->form_validation->set_rules('acc_id', 'Acc ID', 'required|xss_clean');
		$this->form_validation->set_rules('tgian', 'Thoi gian thue', 'xss_clean|numeric');

		if($this->form_validation->run() == FALSE){
			redirect('home22');
		} else {

		//Kiem tra goi cho thue co ton tai hay khong
		$pack = $this->acc->get_pack_by_id( $this->form_validation->set_value('goi_id') );
		if(!$pack){
			$e['title'] = 'Lỗi';
			$e['mess'] = 'Không tồn tại Gói thuê mà bạn vừa yêu cầu.';
			$e['stt'] = 'error';
			echo json_encode($e);
			exit();
		}

		//Kiem tra acc cho thue co ton tai hay khong
		$acc = $this->acc->get_acc_by_id( $this->form_validation->set_value('acc_id') );

		if(!$acc){
			$e['title'] = 'Lỗi';
			$e['mess'] = 'Không tồn tại tài khoản mà bạn vừa yêu cầu.';
			$e['stt'] = 'error';
			echo json_encode($e);
			exit();
		}

		$time_lv = $this->acc->get_time_by_id($pack->time_id);

		if(empty($this->form_validation->set_value('tgian'))){
			// pr('thue ngay',1);
			//Thue ngay
			if($acc->acc_stt != "ROI" && $acc->acc_stt != "CHOHWID"){
				$e['title'] = 'Thất Bại!';
				$e['mess'] = 'Thật tiếc! tài khoản bạn định thuê đã bị bạn khác vừa ấn thuê nhanh hơn rồi. Vui lòng tải lại trang và thuê lại tài khoản khác nhé.';
				$e['stt'] = 'error';
				echo json_encode($e);
				exit();
			}
			
			$stt = 'DANGTHUE';
			
			// $start = max($acc->acc_time_ready, time());
			$start = strtotime($time_lv->time_start);

			// pr( date('Y-m-d H:i:s',$start) ,1);

		} else {
			// pr('dat truoc',1);
			//Dat truoc
			$accs = $this->acc->danhsach();

			// echo '<pre>';
			// print_r($accs);
			// echo '</pre>';
			// die;

			$acc_muon_dat = $accs[$acc->acc_id];
			$tgian = $this->form_validation->set_value('tgian');
			$stop_time = 0;
			foreach($acc_muon_dat AS $amd){
				if($amd->h_stop_time > $stop_time){
					$stop_time = $amd->h_stop_time;
				}
			}
			if($tgian != $stop_time){
				$e['title'] = 'Thất Bại!';
				$e['mess'] = 'Thật tiếc! tài khoản bạn định thuê đã bị bạn khác vừa ấn thuê nhanh hơn rồi. Vui lòng tải lại trang và thuê lại tài khoản khác nhé.';
				$e['stt'] = 'error';
				echo json_encode($e);
				exit();
			} else {
				$stt = 'DANGCHO';
				$start = $tgian + AFTER_TIME * 60 + $kmdem + $kmsang;
			}
		}


		
			$hour = date("H", $start);
			$kmdem = 0;
			$noidungkm = "";
			if($hour == 22 OR $hour == 23 OR ($hour >= 0 AND $hour < 4))
			{
			$kmdem = 2*60*60;
			$noidungkm = "Khuyến mại thêm 2h do thuê đêm.";
			}

			$hour = date("H", $start);
			$kmsang = 0;
			$noidungkm = "";
			if($hour >= 4 AND $hour < 10)
			{
			$kmsang = 1*60*60;
			$noidungkm = "Khuyến mại thêm 1h do thuê sáng sớm.";
			}


		
		// $goi = $this->form_validation->set_value('goi');
		
		// if($stt == 'DANGCHO'){
		// 	$cacgoi = $this->history->cacgoi_dattrc();
		// } else {
		// 	$cacgoi = $this->history->cacgoi();
		// }
		
		// if(!isset($cacgoi[$goi])){
		// 	$e['title'] = 'Lỗi';
		// 	$e['mess'] = 'Không thể thuê do không tồn tại gói bạn yêu cầu.';
		// 	$e['stt'] = 'error';
		// 	echo json_encode($e);
		// 	exit();
		// }
		$goi_thoigian = $this->acc->get_during_by_timeid($pack->time_id);
		$during = $goi_thoigian*60*60;
		// $gia =  $cacgoi[$goi]['gia'];
		


		// pr($goi_thoigian,1);

		$gia = $pack->price;

		if($user_data->user_credit < $gia)
		{
			$e['title'] = 'Quý khách không đủ tiền!';
			$e['mess'] = 'Xin lỗi bạn! số tiền cần trả là '.number_format($gia).'đ. Hiện tại bạn chỉ có '.number_format($user_data->user_credit).'đ. Vui lòng nạp thêm nhé!';
			$e['stt'] = 'error';
			echo json_encode($e);
			exit();
		} else {
			$update = array('acc_stt' => 'DANGTHUE');
			$this->acc->acc_update($acc->acc_id, $update);

			//Trừ tiền
			$new_user_data = array('user_credit' => $user_data->user_credit - $gia, 'user_sogio' => $user_data->user_sogio + $goi_thoigian);
			$this->user->user_update($user_data->user_id, $new_user_data);
			
			//Lưu lịch sử giao dịch
			$new_credit_log = array(
				'c_user_id' => $this->session->userdata('user_id'),
				'c_updown' => 0,
				'c_amount' => $gia,
				'c_notice' => 'Trừ tiền thuê tài khoản trong '.$goi_thoigian.' giờ. Thời gian bắt đầu sử dụng: '.date("H:i d/m", $start).'. Tài khoản giảm từ '.number_format($user_data->user_credit).' xuống còn '.number_format($new_user_data['user_credit']).'.',
				'c_time' => time(),
				'c_ip' => $this->input->ip_address()

			);
			$c_id = $this->user->user_credit_insert($new_credit_log);
			
			$h_key = $acc->acc_pass;

			// do{
			// 	$h_key = $this->history->generateRandomString(28);
			// } while($this->history->get_history_by_h_key($h_key)); 
			
			$new_history = array(
				'h_user_id' => $this->session->userdata('user_id'),
				'h_acc_id' => $acc->acc_id,
				'h_start_time' => $start,
				'h_stop_time' => $start+$during, /* +$kmdem+$kmsang */
				'h_price' => $gia,
				'h_time' => time(),
				'h_c_id' => $c_id,
				'h_stt' => $stt,
				'h_key' => $h_key,
			);
			$this->history->h_insert($new_history);


			$e['title'] = 'Thành công';
			if($stt == 'DANGTHUE' AND $start <= time()) {
				// if($gia >= 10000){
					// $e['mess'] = 'Mã dự thưởng dự thưởng ngày '.date("d/m/Y", time()).' của bạn là '.substr($new_history['h_time'], -4).'. Tài khoản của bạn là: '.$acc->acc_name.'- mật khẩu: '.$acc->acc_pass.'.';
				// } else {
					//$e['mess'] = 'Thuê thành công. Tài khoản của bạn là: '.$acc->acc_name.'- Auth Key: '.$acc->acc_pass.'.';
					$e['mess'] = 'Thuê thành công! Hãy vào mục đã thuê để xem chi tiết.';
				//}
			} else {
				// if($gia >= 10000){
					// $e['mess'] = 'Đặt trước thành công! Bạn sẽ nhận được Key chơi được lúc '.date("H:i d/m/Y", $start).'. Mã dự thưởng dự thưởng ngày '.date("d/m/Y", time()).' của bạn là '.substr($new_history['h_time'], -4).'.';
				// } else {
					$e['mess'] = 'Đặt trước thành công! Bạn sẽ nhận được Key vào lúc '.date("H:i d/m/Y", $start).'.';
				//}
				
			}
			$e['stt'] = 'success';
			echo json_encode($e);
			exit();
		}
		}
	}
	
	public function doigio(){
		echo form_open($this->uri->uri_string());
		echo '<input name="tg" type="datetime-local" value="'. date("Y-m-d\TH:i:s", time()).'" />';
		echo '<input name="un" type="number" value="'.time().'" />';
		echo '<input type="submit" value="Doi sang unixtime" />';
		echo form_close();
		$this->form_validation->set_rules('tg','Thoi gian');
		$this->form_validation->set_rules('un','Thoi gian');
		if($this->form_validation->run() == FALSE){ 
			
		} else {
			echo strtotime($this->form_validation->set_value('tg'));
			echo '<br>';
			echo date("d/m/Y H:i:s", $this->form_validation->set_value('un'));
		}
	}
	
	public function nicklm(){
		$this->load->model('tc/assembly_model', 'asmd');
		$data['categories'] = $this->asmd->get_categories();
		$nicks = $this->asmd->get_assemblies(null, null, null, 1);
		$data['nicks'] = array();
		foreach($nicks AS $nick){
			$data['nicks'][$nick->cat_id][] = $nick;
		}
		$header['title'] = 'Danh sách Nick';
		$this->load->view('header', $header);
		$this->load->view('assemblies', $data);
		$this->load->view('footer');
	}

	public function nick($ass_id){
		$data['ass'] = $this->assmd->get_assembly($ass_id);
		if(!$data['ass']) {redirect('home/nicklm');}

		$data['random_ass'] = $this->assmd->get_random_assemblies(5);
		$header['title'] = $data['ass']->ass_title;
		$header['ogimage'] =  site_url().'style/img/splash/'.$data['ass']->ass_image;
		$header['ogdescription'] = strip_tags($data['ass']->ass_description);
		$this->load->view('header', $header);
		$this->load->view('assembly', $data);
		$this->load->view('footer');
	}
	
	public function mua_nick($ass_id){
		$data['ass'] = $this->assmd->get_assembly($ass_id);
		if(!$data['ass']) {redirect('home/nicklm');}
		
		if($this->session->userdata('user_credit') < $data['ass']->ass_github){
			$this->session->set_flashdata('thongbao',"Bạn cần nạp thêm tiền để mua nick!");
			redirect('home/nicklm#top');
		} elseif($data['ass']->ass_active != 1){
			$this->session->set_flashdata('thongbao',"Tài khoản này vừa bị mua bởi người khác!");
			redirect('home/nicklm#top');
		}
		else {
			//Trừ tiền
			$gia = $data['ass']->ass_github;
			$user_data = $this->user->get_user_by_id($this->session->userdata('user_id'));
			$new_user_data = array('user_credit' => $user_data->user_credit - $gia);
			$this->user->user_update($user_data->user_id, $new_user_data);
			
			//Lưu lịch sử giao dịch
			$new_credit_log = array(
				'c_user_id' => $this->session->userdata('user_id'),
				'c_updown' => 0,
				'c_amount' => $gia,
				'c_notice' => 'Trừ tiền mua nick. Tài khoản và mật khẩu: '.$data['ass']->ass_description.'. Tài khoản giảm từ '.number_format($user_data->user_credit).' xuống còn '.number_format($new_user_data['user_credit']).'.',
				'c_time' => time(),
				'c_ip' => $this->input->ip_address()

			);
			$this->user->user_credit_insert($new_credit_log);
			
			//Ghi nick đã đc mua
			$this->load->model('tc/assembly_model', 'assmd');
			$new_data['ass_active'] = 0;
			$new_data['ass_title'] = $this->session->userdata('user_name').' đã mua. '.$data['ass']->ass_title;
			$this->assmd->assembly_update($ass_id, $new_data);
			redirect('home/taikhoan');
		}
	}
	
	
	public function news($nc_id = null, $from=1){
		$data['page'] = (int)($from/PERPAGE+1);
		$data['news'] = $this->nmd->get_news_by_category($nc_id, "DESC");
		if(empty($data['news'])){
			redirect('home/news');
		}
		$data['count'] = $this->nmd->count_all_news($nc_id);
		if($nc_id != null){
			$header['title'] = $data['title'] = $data['news'][0]->nc_title;
		} else {
			$header['title'] = $data['title'] = "Tin tức";
		}
		
		$header['active'] = 'logs';
		$this->load->view('header', $header);
		$this->load->view('news', $data);
		$this->load->view('footer');
	}
	
	public function view($n_id = null, $n_friendly = null){
		if(!$n_id){
			redirect('news');
		}
		$data['news'] = $this->nmd->get_news($n_id);
		if(empty($data['news'])){
			redirect('home/news');
		}
		if(!$n_friendly){
			$n_friendly = $this->gm_model->friendly_url($data['news']->n_title);
			redirect('home/view/'.$n_id.'-'.$n_friendly.'.html');
		} 
		$data['random_news'] = $this->nmd->get_random_news(10);
		$header['title'] = $data['news']->n_title;
		$this->load->view('header', $header);
		$this->load->view('news_view', $data);
		$this->load->view('footer');
	}
	
	public function t(){
		echo $this->history->generateRandomString();
	}
	
	// public function acc100($from){
		// $add = array();
		// $count = 0;
		// for($i=$from;$i<$from+10; $i++){
			// $pass = $this->history->generateRandomString();
			// $username = 'pepohigiang'.$i;
			// if(file_get_contents('https://www.joduska.me/478/changepass8XCHnUUxw2x.php?name='.$username.'&newpass='.$pass.'') != "Ok"){
				// $add[] = array(
					// 'acc_name' =>  $username,
					// 'acc_pass' => $pass,
					// 'acc_email' => 'higiang.com+abc'.$i.'@gmail.com',
					// 'acc_stt' => 'DUTRU',
				// );
				// $count++;
			// }
		// }
		// $this->acc->insert_bath($add);
		// echo 'Đổi pass và thêm thành công '.$count.' vào CSDL';
	// }
	public function chuyentien(){
		if(empty($this->session->userdata('user_id') ) ) {
			redirect('home/dangnhap');
		}
		$this->form_validation->set_rules('username','Tên đăng nhập', 'xss_clean|required');
		$this->form_validation->set_rules('password','Tên hoặc biệt danh', 'xss_clean');
		if($this->form_validation->run() == FALSE){
			$header['title'] = "Chuyển tiền từ hệ thống cũ";
			$this->load->view('header', $header);
			$this->load->view('chuyentien'); 
			$this->load->view('footer');
		} else {
			$username = $this->form_validation->set_value('username');
			$password = $this->form_validation->set_value('password');
			$arr1 = json_decode($this->file_get_contents_curl('http://vcand.space/?json=auth/generate_auth_cookie&username='.$username.'&password='.$password.'&insecure=cool'));
			if($arr1->status != "ok"){
				$this->session->set_flashdata('error', "Mật khẩu nhập vào chưa đúng. Vui lòng nhập lại hoặc liên hệ với Admin.");
				redirect('home/chuyentien');
			} else {
				$arr2 = json_decode($this->file_get_contents_curl('http://vcand.space/?json=user/get_user_meta&insecure=cool&cookie='.$arr1->cookie.''));
				$credit = $arr2->user_funds;
				if($credit > 0){
					$user = $this->user->get_user_by_id($this->session->userdata('user_id'));
					$new_data['user_credit'] 	= $user->user_credit + $credit ;
					$this->user->user_update($user->user_id, $new_data);
					$this->session->set_userdata('user_credit', $new_data['user_credit']);
					//Lưu lịch sử giao dịch
					$new_credit_log = array(
						'c_user_id' => $this->session->userdata('user_id'),
						'c_updown' => 1,
						'c_amount' => $credit,
						'c_notice' => 'Chuyển tiền từ tài khoản '.$arr2->nickname.' tại web cũ sang. Tài khoản tăng từ '.number_format($user->user_credit).' lên '.number_format($new_data['user_credit']).'',
						'c_time' => time(),
						
					);
					$this->user->user_credit_insert($new_credit_log);
					
					//Trừ hết tiền hiện tại
					
					$this->file_get_contents_curl('http://vcand.space/?json=user/update_user_meta&meta_key=user_funds&meta_value=null&insecure=cool&cookie='.$arr1->cookie.'');
					redirect('home/taikhoan');
				} else {
					$this->session->set_flashdata('error', "Tài khoản của bạn đã hết tiền hoặc có lỗi trong quá trình chuyển đổi. Vui lòng liên hệ Admin.");
					redirect('home/chuyentien');
				}
			}
			
		}
	}
	
	function file_get_contents_curl($url) {
		$ch = curl_init();
		$timeout = 5;
		$userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
		curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;

	}
	
	public function mayman(){
		$this->load->model('mayman_model', 'mayman');
		$this->form_validation->set_rules('g_so','required|less_than_equal_to[99]|greater_than_equal_to[0]');
		$this->form_validation->set_rules('g_tien','required');
		if($this->form_validation->run() == FALSE){
			$data['cf'] = $this->iconfig->get();
			$header['title'] = "Con số may mắn";
			$this->load->view('header', $header);
			$this->load->view('mayman', $data);
			$this->load->view('footer');
		} else {
			if(date("H", time()) >= 18 AND date("H", time()) < 20){
				$this->session->set_flashdata('thongbao', "Từ 18h tới 20h là thời gian trả thưởng, bạn không thể đặt cược!");
				redirect('home/mayman');
			}
			$so = $this->form_validation->set_value('g_so');
			$so = $so%100;
			$so = str_pad($so, 2, '0', STR_PAD_LEFT);
			$tien = $this->form_validation->set_value('g_tien');
			$user_data = $this->user->get_user_by_id($this->session->userdata('user_id'));
			
			if($tien > $user_data->user_credit){
				$this->session->set_flashdata('thongbao', "Số tiền trong tài khoản của bạn không đủ!");
				redirect('home/mayman');
			}  elseif($tien <= 0){
				$this->session->set_flashdata('thongbao', "Bạn đánh 0đ sẽ trúng 0đ, còn đánh số tiền âm thì nếu có trúng còn bị trừ thêm tiền đấy :)). Ai chơi vậy!");
				redirect('home/mayman');
			} else {
				//Cập nhật tiền
				$new_data['user_credit'] = $user_data->user_credit - $tien ;
				$this->user->user_update($user_data->user_id, $new_data);
				$this->session->set_userdata('user_credit', $new_data['user_credit']);
				//Lưu lịch sử giao dịch
				$new_credit_log = array(
					'c_user_id' => $this->session->userdata('user_id'),
					'c_updown' => 0,
					'c_amount' => $tien,
					'c_notice' => 'Đặt cược con số '.$so.' cho ngày '.date("d-m-Y", time()).'. Tài khoản giảm từ '.number_format($user_data->user_credit).' xuống '.number_format($new_data['user_credit']).'',
					'c_time' => time(),
					
				);
				$this->user->user_credit_insert($new_credit_log);
				
				//Ghi đặt cược
				if(date("H", time()) >= 19 AND date("H", time()) <= 23){
					$data['g_ngay'] = date("d-m-Y", time()+24*60*60);
				} else{
					$data['g_ngay'] = date("d-m-Y", time());
				}
				$data['g_user_id'] = $user_data->user_id;
				$data['g_so'] = $so;
				$data['g_tien'] = $tien;
				$data['g_time'] = time();
				$this->mayman->ghi_datcuoc($data);
				redirect('home/taikhoan');
			}
		}
		
	}
	
	public function cronjob_mayman(){
		$this->load->model('mayman_model', 'mayman');
		$this->mayman->crawl_ketqua();
	}

}