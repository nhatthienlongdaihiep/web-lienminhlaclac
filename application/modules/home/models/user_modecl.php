<?php 
class User_model extends CI_Model{
	public function user_insert($data){
		$this->db->insert('user', $data);
		return $this->db->insert_id();
	}
	
	public function get_user_by_login_name($user_login){
		$this->db->where('user_login', $user_login);
		$query = $this->db->get('user');
		return $query->row();
	}
	
	public function check_login($user_login, $pass){
		$user_pass = $this->create_pass($pass);
		$this->db->where('user_login', $user_login);
		$this->db->where('user_password', $user_pass);
		$query = $this->db->get('user');
		return $query->row();
	}
	
	public function create_pass($text){
		return md5(sha1($text));
	}
	
	
	public function get_user_by_fb_id($user_fb_id){
		$this->db->where('user_fb_id', $user_fb_id);
		$query = $this->db->get('user');
		return $query->row();
	}
	
	public function get_user_by_id($user_id){
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('user');
		return $query->row();
	}
	
	public function user_update($user_id, $data){
		$this->db->where('user_id', $user_id);
		$this->db->update('user', $data);
		return $this->db->affected_rows();
	}
	
	public function get_user_credit_log($user_id){
		$this->db->where('c_user_id', $user_id);
		$this->db->order_by('c_id', 'DESC');
		$query = $this->db->get('user_credit');
		return $query->result();
	}
	
	public function user_credit_insert($data){
		$this->db->insert('user_credit', $data);
		return $this->db->insert_id();
	}
}