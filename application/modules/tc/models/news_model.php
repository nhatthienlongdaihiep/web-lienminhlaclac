<?php
/**
 * Created by PhpStorm.
 * User: LIGHT-PC
 * Date: 5/28/2016
 * Time: 4:05 PM
 */

class news_model extends CI_Model
{
    function get_category($nc_id) {
        $this->db->select('*');
        $this->db->from('news_category');
        $this->db->where('nc_id', $nc_id);
        $query = $this->db->get();
        return $query->row();
    }

    function get_news($n_id) {
        $this->db->select('*');
        $this->db->from('news');
        $this->db->where('n_id', $n_id);
        $this->db->join('news_category', 'news_category.nc_id = news.n_nc_id');
        $query = $this->db->get();
        return $query->row();
    }

    function get_random_news($limit){
        $this->db->order_by("n_id","random");
        $this->db->limit($limit, 0);
        $this->db->where('n_active', 1);
        $query = $this->db->get('news');
        return $query->result();
    }

    function get_news_by_category($nc_id = null, $orderby = null, $limit = null, $active = null) {
        $this->db->select('*');
        $this->db->from('news');
        if($nc_id != null) {
            $this->db->where('n_nc_id', $nc_id);
        }
        if($active != null) {
            $this->db->where('n_active', $active);
        }
        if($orderby != null) {
            $this->db->order_by("n_id", $orderby);
        }
        if($limit != null) {
            $this->db->limit($limit);
        }
        $this->db->join('news_category', 'news_category.nc_id = news.n_nc_id');
        $query = $this->db->get();
        return $query->result();
    }
	
	function count_all_news($nc_id = null, $active = null) {
        $this->db->select('*');
        $this->db->from('news');
        if($nc_id != null) {
            $this->db->where('n_nc_id', $nc_id);
        }
        if($active != null) {
            $this->db->where('n_active', $active);
        }
        $this->db->join('news_category', 'news_category.nc_id = news.n_nc_id');
        $query = $this->db->get();
        return count($query->result());
    }

    function get_categories() {
        $query = $this->db->get('news_category');
        return $query->result();
    }

    function news_insert($data) {
        $this->db->insert('news', $data);
        return $this->db->insert_id();
    }

    function news_update($n_id, $data) {
        $this->db->where('n_id', $n_id);
        $this->db->update('news', $data);
        return $this->db->affected_rows();
    }

    function news_delete($n_id) {
        $this->db->delete('news', array('n_id' => $n_id));
        return true;
    }

    function category_insert($data) {
        $this->db->insert('news_category', $data);
        return $this->db->insert_id();
    }

    function category_update($nc_id, $data) {
        $this->db->where('nc_id', $nc_id);
        $this->db->update('news_category', $data);
        return $this->db->affected_rows();
    }

    function champ_update($champ_id, $data) {
        $this->db->where('champ_id', $champ_id);
        $this->db->update('champs', $data);
        return $this->db->affected_rows();
    }

    function category_delete($nc_id) {
        $this->db->delete('news_category', array('nc_id' => $nc_id));
        $this->db->delete('news', array('n_nc_id' => $nc_id));
        return true;
    }

}