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
	
	public function get_random_friend($limit = 8){
		$this->db->where('user_tim_goi >','');
		$this->db->limit($limit, 0);
		$this->db->order_by('user_id', 'RANDOM');
		$query = $this->db->get('user');
		return $query->result();
	}
	
	public function check_login($user_login, $pass){
		$user_pass = $this->create_pass($pass);
		$this->db->where('user_login', $user_login);
		$this->db->where('user_password', $user_pass);
		$query = $this->db->get('user');
		return $query->row();
	}
	
	public function bangxephang($top = 10){
		$this->db->order_by('user_sogio', 'DESC');
		$this->db->limit($top);
		$query = $this->db->get('user');
		return $query->result();
	}
	public function reset_bxh(){
		$this->db->update('user', array('user_sogio' => 0));
	}
	
	public function check_login_toollm($user_login, $pass){
		$db_toollm = $this->load->database('toollm', TRUE);
		$user_pass = $this->create_pass($pass);
		$db_toollm->where('user_login', $user_login);
		$db_toollm->where('user_password', $user_pass);
		$query = $db_toollm->get('user');
		return $query->row();
	}
	public function user_credit_insert_toollm($data){
		$db_toollm = $this->load->database('toollm', TRUE);
		$db_toollm->insert('user_credit', $data);
		return $db_toollm->insert_id(); 
	}
	public function user_update_toollm($user_id, $data){
		$db_toollm = $this->load->database('toollm', TRUE);
		$db_toollm->where('user_id', $user_id);
		$db_toollm->update('user', $data);
		return $db_toollm->affected_rows();
	}
	
	public function create_pass($text){
		return md5(sha1($text));
	}
	
	public function save_admin_credit_log($data){
        $this->db->insert('admin_credit_log', $data);
        return true;
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