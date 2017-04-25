<?php 

class iconfig_model extends CI_Model{
	public function update($data){
		$this->db->where('id', 1);
		$this->db->update('config', array('content' => json_encode($data)));
	}
	public function get(){
		$query = $this->db->get('config');
		$data = $query->row();
		return json_decode($data->content);
	}
}