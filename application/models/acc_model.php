<?php 

class Acc_model extends CI_Model{
	public function get_accs(){
		$query = $this->db->get('acc');
		return $query->result();
	}
	
	public function insert_bath($data){
		$this->db->insert_batch('acc', $data);
	}
	
	public function get_acc_ready($data){
		$this->db->where('acc_stt', 'ROI');
		$this->db->or_where('acc_stt', 'CHOHWID');
		if(!empty($data)){
			$this->db->where_not_in('acc_id', $data);
		}
		$this->db->order_by('acc_time_ready', 'ASC');
		$query = $this->db->get('acc');
		return $query->result();
	}
	
	public function get_acc_by_id($acc_id){
		$this->db->where('acc_id', $acc_id);
		$query = $this->db->get('acc');
		return $query->row();
	}
	
	public function get_acc_by_uid($acc_uid){
		$this->db->where('acc_uid', $acc_uid);
		$query = $this->db->get('acc');
		return $query->row();
	}
	
	public function acc_insert_batch($data){
		$this->db->insert_batch('acc', $data);
		return true;
	}
	
	public function acc_update($acc_id, $data){
		$this->db->where('acc_id', $acc_id);
		$this->db->update('acc', $data);
		return $this->db->affected_rows();
	}
	

	
	/* Function v2 */
	public function update_by_name($acc_name, $data){
		$this->db->where('acc_name', $acc_name);
		$this->db->update('acc', $data);
		return $this->db->affected_rows();
	}
	
	public function update_by_uid($acc_uid, $data){
		$this->db->where('acc_uid', $acc_uid);
		$this->db->update('acc', $data);
		return $this->db->affected_rows();
	}
	
	public function danhsach(){
		$query = $this->db->query("
		SELECT * FROM `acc` LEFT JOIN `history` ON(`history`.`h_acc_id` = `acc`.`acc_id`) WHERE `history`.`h_stt` != 'XONG' ORDER BY `history`.`h_stop_time`  
		");
		$his = $query->result();
		
		$acc_ids = array();
		if(count($his) > 0){
			//Nhom lich su theo acc_id
			//Lay danh sach tat ca cac acc
			$accs = array();
			foreach($his AS $hi){
				if(isset($accs[$hi->h_acc_id])){
					$accs[$hi->h_acc_id][] = $hi;
				} else {
					$acc_ids[] = $hi->h_acc_id;
					$accs[$hi->h_acc_id] = array();
					$accs[$hi->h_acc_id][] = $hi;
				}
			}
			//usort($accs, [$this, 'cmp']);
			return $accs;
		}
		return array();
		
	}

	public function getPackAll(){
		$this->db->select('h.id,h.time_id,h.acc_id,h.price, t.time_start, t.time_end');
		$this->db->from('hired as h');
		$this->db->join('time_lv as t', 't.id = h.time_id');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}
		return false;
	}

	public function get_pack_by_id($pack_id){
		$this->db->select();
		$this->db->where('id', $pack_id);
		$query = $this->db->get('hired');
		if($query->num_rows() > 0){
			return $query->row();
		}
		return false;
	}



	public function get_time_by_id($timeid){
		$this->db->select();
		$this->db->where('id',$timeid);
		$query = $this->db->get('time_lv');
		if($query->num_rows() > 0){
			return $query->row();
		}
		return false;
	}
	public function get_during_by_timeid($timeid){
		$this->db->select();
		$this->db->where('id',$timeid);
		$query = $this->db->get('time_lv');
		if($query->num_rows() > 0){

			$dur = getTimeDiff($query->row()->time_start, $query->row()->time_end);
			return date('H', strtotime( $dur ) );
		}
		return false;
	}
	/* Function v2 */
}