<?php 
error_reporting(0);
class Api extends CI_Controller{
	public function __construct(){
		header('Access-Control-Allow-Origin: *');  
		parent::__construct();
		$this->load->model('history_model', 'history');
	}
	public function index($key = ""){
		header('Access-Control-Allow-Origin: *');  
		if(strlen($key) != 32){
			echo $this->encryption(json_encode(array('status' => '0')));
			exit();
		}
		else {
			$data = $this->history->get_history_by_h_key($key);
			if(!$data){
				echo $this->encryption(json_encode(array('status' => '0')));
				exit();
			} else {
				if($data->h_stt != "DANGTHUE"){
					$data->h_key = "CHUADENGIO";
					$data->h_notice = "Sai thời gian sử dụng. Key của bạn chỉ dùng được từ ".date("H:i d/m/Y", $data->h_start_time)." tới ".date("H:i d/m/Y", $data->h_stop_time).".";
					echo $this->encryption(json_encode(array('status' => '1', 'data'=> $data)));
					exit();
				} else {
					$data->h_stop_time = $data->h_stop_time - BEFORE_TIME * 60;
					$data->acc_pass =  preg_replace("/[^A-Za-z0-9]/", '', $data->acc_pass);
					echo $this->encryption(json_encode(array('status' => '2', 'data'=> $data)));
					exit();
				}
			}
		}
	}
	
	function encryption($buffer){
		$extra = 8 - (strlen($buffer) % 8);
		// add the zero padding
		if($extra > 0) {
			for($i = 0; $i < $extra; $i++) {
				$buffer .= "\0";
			}
		}
		// very simple ASCII key and IV
		$key = "patsdrowDR0wSS@P6660juht";
		$iv = "patsdrow";
		// hex encode the return value
		return bin2hex(mcrypt_cbc(MCRYPT_3DES, $key, $buffer, MCRYPT_ENCRYPT, $iv));
	}
}