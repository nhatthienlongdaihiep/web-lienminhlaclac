<?php

class mayman_model extends CI_Model{
	public $sogiai = 27;
	
	public function crawl_ketqua(){
		//Xem đã lấy kết quả hôm nay chưa
		$kq = $this->lay_ketqua(date("d-m-Y", time()));
		$duoi = json_decode($kq->ketqua, true);
		if(!$kq OR count(json_decode($kq->ketqua)) != $this->sogiai){
			$ketqua = simplexml_load_file('http://xskt.com.vn/rss-feed/mien-bac-xsmb.rss');
			$arr1 = array(': ', ' - ', "\nĐB");
			$arr2 = array('', '-','');
			$giai_txt = str_replace($arr1,$arr2, $ketqua->channel->item->description);
			$cac_giai = explode("\n",$giai_txt);	
			$duoi = array();
			foreach($cac_giai AS $giai){
				$giai_con = array();
				$giai_con = explode("-", $giai);
				foreach($giai_con AS $con){
					$duoi[] = substr($con, -2,2);
				}
				
			}

			
			if(count($duoi) != $this->sogiai){
				$this->load->model('history_model', 'history');
				$this->history->pushcrew("Lỗi lấy KQXS ngày ".date("d", time()), site_url('tc/mayman'));
			}
		
			//Có 2 trường hợp, ko có kết quả hoặc có nhưng chưa lấy hết toàn bộ số giải
			if(!$kq){
				//Ghi kết quả
				$data['ngay'] = date('d-m-Y', time());
				$data['ketqua'] = json_encode($duoi);
				$this->ghi_ketqua($data);
			} else {
				//Ghi kết quả
				$cn_ngay = date('d-m-Y', time());
				$data['ketqua'] = json_encode($duoi);
				$this->capnhat_ketqua($cn_ngay, $data);
			}
		} else {
			$this->trathuong(date('d-m-Y', time()), $duoi);
		}

	}
	
	public function lay_ketqua($ngay){
		$this->db->where('ngay', $ngay);
		$query = $this->db->get('kqxs');
		return $query->row();
	}
	
	public function ghi_ketqua($data){
		$this->db->insert('kqxs', $data);
	}
	
	public function capnhat_ketqua($ngay, $data){
		$this->db->where('ngay', $ngay);
		$this->db->update('kqxs', $data);
	}
	
	public function lay_nguoichoi($ngay){
		$this->db->where('g_ngay', $ngay);
		$this->db->where('g_trathuong', '0');
		$query = $this->db->get('user_game');
		return $query->result();
	}
	
	public function get_by_g_id($g_id){
		$this->db->where('g_id', $g_id);
		$query = $this->db->get('user_game');
		return $query->row();
	}
	
	public function trathuong($ngay, $ketqua){
		$chois = $this->lay_nguoichoi($ngay);
		
		foreach($chois AS $choi){
			//Ghi lại đã duyệt qua
			$user_game_update['g_trathuong'] = '1';
			$this->user_game_update($choi->g_id, $user_game_update);
			
			//Xét xem có trúng hay ko
			if(in_array($choi->g_so, $ketqua)){
				$this->load->model('iconfig_model', 'iconfig');
				$cf = $this->iconfig->get();
					
				//Có thể ăn nhiều nháy
				foreach($ketqua AS $kq){
					
					
					if($kq == $choi->g_so){
						$game = $this->get_by_g_id($choi->g_id);
						$user_game_update['g_tien_trung'] = $game->g_tien_trung + $choi->g_tien*$cf->tile_lo;
						$this->user_game_update($choi->g_id, $user_game_update);
						
						//Cập nhật tiền
						
						$this->load->model('User_model', 'user');
						
						$user_data = $this->user->get_user_by_id($choi->g_user_id);
						$new_data['user_credit'] = $user_data->user_credit + $choi->g_tien*$cf->tile_lo;
						
						$this->user->user_update($user_data->user_id, $new_data);
						
						//Lưu lịch sử giao dịch
						$new_credit_log = array(
							'c_user_id' => $choi->g_user_id,
							'c_updown' => 2,
							'c_amount' => $choi->g_tien*$cf->tile_lo,
							'c_notice' => 'Trả thưởng số '.$choi->g_so.' cho ngày ngày '.date("d-m-Y", time()).'. Tài khoản tăng từ '.number_format($user_data->user_credit).' lên '.number_format($new_data['user_credit']).'',
							'c_time' => time(),
							
						);
						$this->user->user_credit_insert($new_credit_log);
					}
				}
			}
		}
	}
	
	public function user_game_update($g_id, $data){
		$this->db->where('g_id', $g_id);
		$this->db->update('user_game', $data);
	}
	
	public function ghi_datcuoc($data){
		$this->db->insert('user_game', $data);
	}
}