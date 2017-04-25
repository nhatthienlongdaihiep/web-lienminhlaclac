<?php 

class Stats_model extends CI_Model{
	public function baeod($date = 0 ){
		if($date == 0){
			$date = time();
		}
		$times['start'] = strtotime("midnight", $date);
		$times['stop'] = min(strtotime("tomorrow", $times['start']) - 1, time());
		return $times;
	}
	
	public function count_user_credit($c_updown = 1, $times = array()){
		if(empty($times)){
			$times = $this->baeod();
		}
		$query = $this->db->query("
		SELECT SUM(c_amount) AS tong FROM user_credit  WHERE c_updown = '".$c_updown."' AND c_time > '".$times['start']."' AND c_time <= '".$times['stop']."'
		");
		return $query->row();
	}
	
	public function count_new_user($times = array()){
		if(empty($times)){
			$times = $this->baeod();
		}
		$this->db->where('user_join_date >', date('Y-m-d h:i:s',$times['start']));
		$this->db->where('user_join_date <=', date('Y-m-d h:i:s',$times['stop']));
		return $this->db->count_all_results('user');
	}
	
	public function count_history($times = array()){
		if(empty($times)){
			$times = $this->baeod();
		}
		$this->db->where('h_time >', $times['start']);
		$this->db->where('h_time <=', $times['stop']);
		$query = $this->db->get('history');
		
		$results = $query->result();
		$tgian = 0;
		$luot = 0;
		if(count($results) == 0){
			return array('tgian' => $tgian, 'luot' => $luot);
		} else {
			foreach($results AS $result){
				$tgian += $result->h_stop_time - $result->h_start_time;
				$luot ++;
			}
			return array('tgian' => $tgian, 'luot' => $luot);
		}
	}
}