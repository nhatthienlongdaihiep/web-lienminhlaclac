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


	/* BEGIN OF HIRED MANAGER ======================================== */
	function getHiredAll(){
		$this->db->select('	a.acc_id,
							a.acc_name,
							a.acc_pass,
							t.time_name,
							t.time_start,
							t.time_end,
							h.time_id,
							h.id,
							h.price,
							h.created'
		);
		$this->db->from('hired as h');
		$this->db->join('acc as a', 'a.acc_id = h.acc_id');
		$this->db->join('time_lv as t', 't.id = h.time_id');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}
		return false;
	}
	function getHiredDetail($id){
		$this->db->select('	a.acc_id,
							a.acc_name,
							a.acc_pass,
							t.time_name,
							t.time_start,
							t.time_end,
							h.time_id,
							h.id,
							h.price,
							h.created'
		);
		$this->db->from('hired as h');
		$this->db->join('acc as a', 'a.acc_id = h.acc_id');
		$this->db->join('time_lv as t', 't.id = h.time_id');
		$this->db->where("h.id = $id");
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return $query->row();
		}
		return false;
	}
	function insertHired($new_data){
		$this->db->insert('hired', $new_data);
	}
	function updateHired($id, $new_data){
		$this->db->where('id', $id);
		$this->db->update('hired', $new_data);
	}
	function delHired($id){
		$this->db->where('id',$id);
		$this->db->delete('hired');
	}
	/* END OF HIRED MANAGER ======================================== */
}