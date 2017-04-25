<?php 

class acc_model extends CI_Model {
	function get_all(){
		$query = $this->db->get('acc');
		return $query->result();
	}
	
	function get_acc_by_id($acc_id){
		$this->db->where('acc_id', $acc_id);
		$query = $this->db->get('acc');
		return $query->row();
	}
	function update($acc_id, $new_data){
		$this->db->where('acc_id', $acc_id);
		$this->db->update('acc', $new_data);
	}
	function delete($acc_id){
		$this->db->where('acc_id', $acc_id);
		$this->db->delete('acc');
	}
	
	function insert($new_data){
		$this->db->insert('acc', $new_data);
	}

	//Lay time lv cho dashboard
	function getTimeLv(){
		$this->db->select();
		$query = $this->db->get('time_lv');
		if($query->num_rows() > 0){
			return $query->result();
		}
		return false;
	}
	function insertTime($new_data){
		$this->db->insert('time_lv',$new_data);
	}
	function getTimeLvDetail($id){
		$this->db->select();
		$this->db->where('id',$id);
		$query = $this->db->get('time_lv');
		if($query->num_rows() > 0){
			return $query->row();
		}
		return false;
	}
	function updateTime($id, $new_data){
		$this->db->where('id',$id);
		$this->db->update('time_lv',$new_data);
	}
	function delTime($id){
		$this->db->where('id',$id);
		$this->db->delete('time_lv');
	}
}