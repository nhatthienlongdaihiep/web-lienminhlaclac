<?php 

class History_model extends CI_Model{
	public function cmp($a, $b)
	{
		if ($a['tgian'] == $b['tgian']) {
			return 0;
		}
		return ($a['tgian'] < $b['tgian']) ? -1 : 1;
	}
	
	
	public function cacgoi(){
		$this->load->model('iconfig_model', 'iconfig');
		$cf = $this->iconfig->get();
		$goi_txt = $cf->goi;
		$arr1 = explode("\n", $goi_txt);
		$rt = array();
		foreach($arr1 AS $key => $value){
			$arr2 = explode("-", $value);
			if($arr2[0] < 1){
				$ten = ($arr2[0]*60).'p';
			} else {
				$ten = $arr2[0].'h';
			}
			$tgian = $arr2[0];
			//if(date("H", time()) == 22 OR date("H", time()) == 23 OR ( date("H", time()) >= 0 AND date("H") <= 2)){
			//	$tgian += 1;
			//	$ten = (($arr2[0]+2)).'h';
			//}
			$rt[$key] = array(
				'ten' => $ten,
				'tgian' => $tgian,
				'gia' => $arr2[1]
			);
		}
		return $rt;
		
	} 
	
	public function cacgoi_dattrc(){
		$this->load->model('iconfig_model', 'iconfig');
		$cf = $this->iconfig->get();
		$goi_txt = $cf->goi;
		$arr1 = explode("\n", $goi_txt);
		$rt = array();
		foreach($arr1 AS $key => $value){
			$arr2 = explode("-", $value);
			if($arr2[0] < 1){
				$ten = ($arr2[0]*60).'p';
			} else {
				$ten = $arr2[0].'h';
			}
			$tgian = $arr2[0];
			$rt[$key] = array(
				'ten' => $ten,
				'tgian' => $tgian,
				'gia' => $arr2[1]
			);
		}
		return $rt;
  
	}
	
	public function get_history_by_acc_id($user_id, $h_stts = array('DANGTHUE', 'DANGCHO')){
		$this->db->where('h_acc_id', $user_id);
		$this->db->where_in('h_stt', $h_stts);
		$query = $this->db->get('history');
		return $query->result();
	}
	
	public function h_insert_batch($data){
		$this->db->insert_batch('history', $data);
		return true;
	}
	
	public function h_insert($data){
		$this->db->insert('history', $data);
		return $this->db->insert_id();
	}
	 
	public function get_history_by_acc_id2($h_acc_id) {
        $this->db->from('history');
        $this->db->where('h_acc_id',$h_acc_id);
        $this->db->order_by('h_start_time', 'DESC');
        $query = $this->db->get();
        return $query->row();
    }
	
	public function get_history_by_h_id($h_id) {
        $this->db->from('history');
        $this->db->where('h_id',$h_id);
        $this->db->join('user', 'user.user_id = history.h_user_id');
        $this->db->join('user_credit', 'user_credit.c_id = history.h_c_id');
        $query = $this->db->get();
        return $query->row();
    }
	
	public function get_history_by_h_key($h_key) {
        $this->db->from('history');
        $this->db->where('h_key',$h_key);
		$this->db->join('acc', 'acc.acc_id = history.h_acc_id');
        $query = $this->db->get();
        return $query->row();
    }
	
	public function h_update($h_id, $data){
		$this->db->where('h_id', $h_id);
		$this->db->update('history', $data);
		return $this->db->affected_rows();
	}
	
	public function get_acc_by_user_id($user_id){
		$this->db->where('h_user_id', $user_id);
		$this->db->join('acc', 'acc.acc_id = history.h_acc_id');
		$query = $this->db->get('history');
		return $query->result();
	}
	
	//Dang cho, chuyen sang dang thue
	public function cronjob(){
		$this->db->where('h_stt', 'DANGCHO');
		$this->db->where('h_start_time <=',time());
		$this->db->join('acc', 'acc.acc_id = history.h_acc_id');
		$query = $this->db->get('history');
		$res = $query->result();
		
		//h_ids
		$h_ids = array();
		$acc_ids = array();
		if(count($res) > 0){
			foreach($res AS $re){
				if(!in_array($re->h_id, $h_ids)){
					$h_ids[] = $re->h_id;
				}
				if(!in_array($re->h_acc_id, $acc_ids)){
					$acc_ids[] = $re->h_acc_id;
				}
			}
			$this->acc_update_batch('DANGTHUE', $acc_ids);
			$this->h_update_batch('DANGTHUE', $h_ids);
		}
		
	}
	
	//Dang thue chuyen sang chodoipass
	public function cronjob2(){
		$this->db->where('h_stt', 'DANGTHUE');
		$this->db->where('h_stop_time <=',time()+BEFORE_TIME*60);
		$this->db->join('acc', 'acc.acc_id = history.h_acc_id', 'left');
		$query = $this->db->get('history');
		$res = $query->result();

		$this->request_new_pass($res);

		
	}

	
	public function acc_update_batch($stt, $acc_ids){
		$this->db->where_in('acc_id', $acc_ids);
		$this->db->update('acc', array('acc_stt' => $stt) );
	}
	
	public function acc_update_batch2($stt, $acc_ids){
		$this->db->where_in('acc_id', $acc_ids);
		$this->db->update('acc', array('acc_stt' => $stt, 'acc_last_time_request_pass' => time()) );
	}
	
	public function acc_update_timerequest_batch($acc_ids){
		$this->db->where_in('acc_id', $acc_ids);
		$this->db->update('acc', array('acc_last_time_request_pass' => time()) );
	}
	
	public function h_update_batch($stt, $h_ids){
		$this->db->where_in('h_id', $h_ids);
		if($stt == "XONG"){
			$this->db->update('history', array('h_stt' => $stt, 'h_key' => NULL));
		} else {
			$this->db->update('history', array('h_stt' => $stt));
		}
		
	}
	
	public function request_new_pass($res){
		$h_ids = array();
		if(count($res) > 0){
			foreach($res AS $re){
				$new_pass = $this->generateRandomString();
				// $url = 'https://www.joduska.me/478/changepass8XCHnUUxw2x.php?name='.$re->acc_name.'&newpass='.$new_pass.'';
				// $options = array(
					// 'http' => array(
						// 'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
						// 'method'  => 'GET',
					// )
				// );
				// $context  = stream_context_create($options);
				// $result = file_get_contents($url, false, $context);
				// if($result != "OK"){
					// $this->pushcrew($result);
				// } else {
					//$new_data['acc_pass'] = $new_pass;
					$new_data['acc_stt'] = "CHOHWID";
					$new_data['acc_time_ready'] = time()+(BEFORE_TIME+AFTER_TIME)*60;
					$new_data['acc_last_time_request_pass'] = time();
					$this->update_acc($re->acc_id, $new_data);
					
					if(!in_array($re->h_id, $h_ids)){
						$h_ids[] = $re->h_id;
					}
				//}
			}
			$this->h_update_batch('XONG', $h_ids);
		}
	}	
	
	public function update_acc($acc_id, $data){
		$this->db->where('acc_id', $acc_id);
		$this->db->update('acc', $data);
		return true;
	}
	
	public function pushcrew($acc_name = ''){
		$title = 'Lỗi đổi pass '.$acc_name.'.';
		$message = 'Lúc '.date("H:i:s d/m/Y", time()).'';
		$url = 'https://toollm.com/img/bg';

		$apiToken = '5f83cac5d94611d38b3174c69fdc1826';

		$curlUrl = 'https://pushcrew.com/api/v1/send/all';
		
		//set POST variables
		$fields = array(
		  'title' => $title,
		  'message' => $message,
		  'url' => $url
		);

		$httpHeadersArray = Array();
		$httpHeadersArray[] = 'Authorization: key='.$apiToken.'';

		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $curlUrl);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeadersArray);

		//execute post
		$result = curl_exec($ch);
	}

	function generateRandomString($length = 12) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString.date("Hi", time());
	}
	 
	function quayso($so){
		$beginOfDay = strtotime("midnight", time());
		$this->db->like('h_time', $so, 'before'); 
		$this->db->where('h_start_time >', $beginOfDay);
		$this->db->where('h_price >=', 10000);
		
		$this->db->join('user', 'user.user_id = history.h_user_id');
		$query = $this->db->get('history');
		return $query->result();
	}
	
}