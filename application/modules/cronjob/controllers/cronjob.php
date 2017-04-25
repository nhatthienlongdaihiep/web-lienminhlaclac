<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class Cronjob extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('History_model', 'history');
		$this->load->model('Acc_model', 'acc');
	}
	
	public function index(){
		$this->history->cronjob();
		$this->history->cronjob2();
		echo 'Done';
	}
	
	public function gmail(){
	set_time_limit(4000);
 
	// Connect to gmail
	$imapPath = '{imap.gmail.com:993/imap/ssl}INBOX';
	$username = 'joduskachodoipassr.com@gmail.com';
	$password = 'joduskachodoipassr';
	 
	// try to connect
	//Chỉ lấy email trong khoảng 60 phút gần đây
	$date = date("j-M-Y", time()-60*60); 
	$inbox = imap_open($imapPath,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());
	$emails = imap_search($inbox,'UNSEEN FROM "LeagueSharp" SINCE ' . $date);
	if(empty($emails)){
		echo 'Khong co mail moi';
		exit();  
	}
	foreach($emails AS $mail){
		$headerInfo = imap_headerinfo($inbox,$mail);
		if($headerInfo->subject == "Your new password LeagueSharp"){
			$message = quoted_printable_decode(imap_fetchbody($inbox,$mail,1));
			preg_match('/Your username is: (.*)$/im', $message, $matches);
			$acc_name = trim(strip_tags($matches[1]));
			preg_match('/Your new password is: (.*)$/im', $message, $matches);
			$update = array(
				'acc_pass' => trim(strip_tags($matches[1])),
				'acc_time_ready' => time()+(BEFORE_TIME+AFTER_TIME)*60,
				'acc_stt' => 'CHOHWID',
			);
			$this->acc->update_by_name($acc_name, $update);
		}
		
		if($headerInfo->subject == "Password recovery information from LeagueSharp"){
			$message = quoted_printable_decode(imap_fetchbody($inbox,$mail,1));
			preg_match('/User ID: (.*)$/im', $message, $matches);
			$acc_uid = trim(strip_tags($matches[1]));
			preg_match('/Validation Key: (.*)$/im', $message, $matches);
			$acc_aid = trim(strip_tags($matches[1]));
			
			$update = array(
				'acc_aid' => $acc_aid,
			);
			$acc = $this->acc->get_acc_by_uid($acc_uid);
			if(file_get_contents($acc->acc_lrp.'?n='.$acc->acc_name.'&u='.$acc_uid.'&a='.$acc_aid) == 'Loi'){
				$this->history->pushcrew($acc->acc_name);
				
			}
			$this->acc->update_by_uid($acc_uid, $update);
		}
	}
	 
	// colse the connection
	imap_expunge($inbox);
	imap_close($inbox);


	}
}