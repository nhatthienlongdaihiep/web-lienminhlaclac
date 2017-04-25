<?php
class History_model extends CI_Model{
	public function get_all($page, $limit = PERPAGE){
		$this->db->from('history');
		$this->db->where('h_stt !=', 'XONG');
		$this->db->limit($limit, ($page-1)*$limit);
		$this->db->join('acc', 'acc.acc_id = history.h_acc_id');
		$this->db->join('user', 'user.user_id = history.h_user_id');
		$this->db->order_by('h_id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_all_history_by_acc_id($h_acc_id, $limit = 20) {
        $this->db->from('history');
        $this->db->where('h_acc_id',$h_acc_id);
        $this->db->order_by('h_start_time', 'DESC');
		$this->db->join('user', 'user.user_id = history.h_user_id');
		$this->db->join('acc', 'acc.acc_id = history.h_acc_id');
		//$this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }
	
    public function get_history_by_h_id($h_id) {
        $this->db->from('history');
        $this->db->where('h_id',$h_id);
        $this->db->join('user', 'user.user_id = history.h_user_id');
        $this->db->join('user_credit', 'user_credit.c_id = history.h_c_id');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_history_by_acc_id($h_acc_id) {
        $this->db->from('history');
        $this->db->where('h_acc_id',$h_acc_id);
        $this->db->order_by('h_start_time', 'DESC');
        $query = $this->db->get();
        return $query->row();
    }

    public function del_history_by_h_id($h_id){
        $this->db->where('h_id',$h_id);
        $this->db->delete('history');
        return $this->db->affected_rows();
    }

    public function del_user_credit_log($c_id){
        $this->db->where('c_id', $c_id);
        $this->db->delete('user_credit');
        return $this->db->affected_rows();
    }

    public function update_user_credit($user_id, $price){
        $this->db->where('user_id', $user_id);
        $this->db->set('user_credit', '`user_credit` +'.$price.'', FALSE);
        $this->db->update('user');
        return $this->db->affected_rows();
    }

    public function save_admin_credit_log($data){
        $this->db->insert('admin_credit_log', $data);
        return true;
    }
}