<?php
/**
 * Created by PhpStorm.
 * User: LIGHT-PC
 * Date: 5/28/2016
 * Time: 4:05 PM
 */

class Assembly_model extends CI_Model
{
    function get_category($cat_id) {
        $this->db->select('*');
        $this->db->from('assembly_category');
        $this->db->where('cat_id', $cat_id);
        $query = $this->db->get();
        return $query->row();
    }

    function get_assembly($ass_id) {
        $this->db->select('*');
        $this->db->from('assemblies');
        $this->db->where('ass_id', $ass_id);
        $this->db->join('assembly_category', 'assembly_category.cat_id = assemblies.ass_cat_id');
        $query = $this->db->get();
        return $query->row();
    }

    function get_random_assemblies($limit){
        $this->db->order_by("ass_id","random");
        $this->db->limit($limit, 0);
        $this->db->where('ass_active', 1);
        $query = $this->db->get('assemblies');
        return $query->result();
    }

    function get_assemblies($cat_id = null, $orderby = null, $limit = null, $active = null) {
        $this->db->select('*');
        $this->db->from('assemblies');
        if($cat_id != null) {
            $this->db->where('ass_cat_id', $cat_id);
        }
        if($active != null) {
            $this->db->where('ass_active', $active);
        }
        if($orderby != null) {
            $this->db->order_by("ass_id", $orderby);
        }
        if($limit != null) {
            $this->db->limit($limit);
        }
        $this->db->join('assembly_category', 'assembly_category.cat_id = assemblies.ass_cat_id');
        $query = $this->db->get();
        return $query->result();
    }

    function get_categories() {
        $query = $this->db->get('assembly_category');
        return $query->result();
    }

    function assembly_insert($data) {
        $this->db->insert('assemblies', $data);
        return $this->db->insert_id();
    }

    function assembly_update($ass_id, $data) {
        $this->db->where('ass_id', $ass_id);
        $this->db->update('assemblies', $data);
        return $this->db->affected_rows();
    }

    function assembly_delete($ass_id) {
        $this->db->delete('assemblies', array('ass_id' => $ass_id));
        return true;
    }

    function category_insert($data) {
        $this->db->insert('assembly_category', $data);
        return $this->db->insert_id();
    }

    function category_update($cat_id, $data) {
        $this->db->where('cat_id', $cat_id);
        $this->db->update('assembly_category', $data);
        return $this->db->affected_rows();
    }

    function champ_update($champ_id, $data) {
        $this->db->where('champ_id', $champ_id);
        $this->db->update('champs', $data);
        return $this->db->affected_rows();
    }

    function category_delete($cat_id) {
        $this->db->delete('assembly_category', array('cat_id' => $cat_id));
        $this->db->delete('assemblies', array('ass_cat_id' => $cat_id));
        return true;
    }

    function get_champs($join = 'left'){
        $this->db->from('champs');
        $this->db->join('assemblies', 'assemblies.ass_id = champs.champ_ass_id', $join);
        $query = $this->db->get();
        return $query->result();
    }

    function get_champ($champ_id){
        $this->db->where('champ_id', $champ_id);
        $query = $this->db->get('champs');
        return $query->row();
    }

    function insert_champ(){
        $insert = array(
            array('champ_name' => "Aatrox"),
            array('champ_name' => "Ahri"),
            array('champ_name' => "Akali"),
            array('champ_name' => "Alistar"),
            array('champ_name' => "Amumu"),
            array('champ_name' => "Anivia"),
            array('champ_name' => "Annie"),
            array('champ_name' => "Ashe"),
            array('champ_name' => "Aurelion Sol"),
            array('champ_name' => "Azir"),
            array('champ_name' => "Bard"),
            array('champ_name' => "Blitzcrank"),
            array('champ_name' => "Brand"),
            array('champ_name' => "Braum"),
            array('champ_name' => "Caitlyn"),
            array('champ_name' => "Cassiopeia"),
            array('champ_name' => "Cho'Gath"),
            array('champ_name' => "Corki"),
            array('champ_name' => "Darius"),
            array('champ_name' => "Diana"),
            array('champ_name' => "Dr. Mundo"),
            array('champ_name' => "Draven"),
            array('champ_name' => "Ekko"),
            array('champ_name' => "Elise"),
            array('champ_name' => "Evelynn"),
            array('champ_name' => "Ezreal"),
            array('champ_name' => "Fiddlesticks"),
            array('champ_name' => "Fiora"),
            array('champ_name' => "Fizz"),
            array('champ_name' => "Galio"),
            array('champ_name' => "Gangplank"),
            array('champ_name' => "Garen"),
            array('champ_name' => "Gnar"),
            array('champ_name' => "Gragas"),
            array('champ_name' => "Graves"),
            array('champ_name' => "Hecarim"),
            array('champ_name' => "Heimerdinger"),
            array('champ_name' => "Illaoi"),
            array('champ_name' => "Irelia"),
            array('champ_name' => "Janna"),
            array('champ_name' => "Jarvan IV"),
            array('champ_name' => "Jax"),
            array('champ_name' => "Jayce"),
            array('champ_name' => "Jhin"),
            array('champ_name' => "Jinx"),
            array('champ_name' => "Kalista"),
            array('champ_name' => "Karma"),
            array('champ_name' => "Karthus"),
            array('champ_name' => "Kassadin"),
            array('champ_name' => "Katarina"),
            array('champ_name' => "Kayle"),
            array('champ_name' => "Kennen"),
            array('champ_name' => "Kha'Zix"),
            array('champ_name' => "Kindred"),
            array('champ_name' => "Kog'Maw"),
            array('champ_name' => "LeBlanc"),
            array('champ_name' => "Lee Sin"),
            array('champ_name' => "Leona"),
            array('champ_name' => "Lissandra"),
            array('champ_name' => "Lucian"),
            array('champ_name' => "Lulu"),
            array('champ_name' => "Lux"),
            array('champ_name' => "Malphite"),
            array('champ_name' => "Malzahar"),
            array('champ_name' => "Maokai"),
            array('champ_name' => "Master Yi"),
            array('champ_name' => "Miss Fortune"),
            array('champ_name' => "Mordekaiser"),
            array('champ_name' => "Morgana"),
            array('champ_name' => "Nami"),
            array('champ_name' => "Nasus"),
            array('champ_name' => "Nautilus"),
            array('champ_name' => "Nidalee"),
            array('champ_name' => "Nocturne"),
            array('champ_name' => "Nunu"),
            array('champ_name' => "Olaf"),
            array('champ_name' => "Orianna"),
            array('champ_name' => "Pantheon"),
            array('champ_name' => "Poppy"),
            array('champ_name' => "Quinn"),
            array('champ_name' => "Rammus"),
            array('champ_name' => "Rek'Sai"),
            array('champ_name' => "Renekton"),
            array('champ_name' => "Rengar"),
            array('champ_name' => "Riven"),
            array('champ_name' => "Rumble"),
            array('champ_name' => "Ryze"),
            array('champ_name' => "Sejuani"),
            array('champ_name' => "Shaco"),
            array('champ_name' => "Shen"),
            array('champ_name' => "Shyvana"),
            array('champ_name' => "Singed"),
            array('champ_name' => "Sion"),
            array('champ_name' => "Sivir"),
            array('champ_name' => "Skarner"),
            array('champ_name' => "Sona"),
            array('champ_name' => "Soraka"),
            array('champ_name' => "Swain"),
            array('champ_name' => "Syndra"),
            array('champ_name' => "Tahm Kench"),
            array('champ_name' => "Taliyah"),
            array('champ_name' => "Talon"),
            array('champ_name' => "Taric"),
            array('champ_name' => "Teemo"),
            array('champ_name' => "Thresh"),
            array('champ_name' => "Tristana"),
            array('champ_name' => "Trundle"),
            array('champ_name' => "Tryndamere"),
            array('champ_name' => "Twisted Fate"),
            array('champ_name' => "Twitch"),
            array('champ_name' => "Udyr"),
            array('champ_name' => "Urgot"),
            array('champ_name' => "Varus"),
            array('champ_name' => "Vayne"),
            array('champ_name' => "Veigar"),
            array('champ_name' => "Vel'Koz"),
            array('champ_name' => "Vi"),
            array('champ_name' => "Viktor"),
            array('champ_name' => "Vladimir"),
            array('champ_name' => "Volibear"),
            array('champ_name' => "Warwick"),
            array('champ_name' => "Wukong"),
            array('champ_name' => "Xerath"),
            array('champ_name' => "Xin Zhao"),
            array('champ_name' => "Yasuo"),
            array('champ_name' => "Yorick"),
            array('champ_name' => "Zac"),
            array('champ_name' => "Zed"),
            array('champ_name' => "Ziggs"),
            array('champ_name' => "Zilean"),
            array('champ_name' => "Zyra")
        );
        $this->db->insert_batch('champs', $insert);
    }
}