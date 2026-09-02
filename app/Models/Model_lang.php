<?php
namespace App\Models;



class Model_lang extends \App\Models\CI3Model {

    public function get_default_language_id()
    {
        $query = $this->db->query("SELECT * FROM tbl_lang WHERE lang_default=?", array('Yes'));
        return $query->getRowArray();
    }

    public function get_detail_by_language_id($id)
    {
        $query = $this->db->query("SELECT * FROM tbl_lang_detail WHERE lang_id=?", array($id));
        return $query->getResultArray();
    }

    public function show_all_language() {
        $query = $this->db->query("SELECT * FROM tbl_lang");
        return $query->getResultArray();
    }

    public function get_direction_by_lang_id($id)
    {
        $query = $this->db->query("SELECT * FROM tbl_lang WHERE lang_id=?", array($id));
        return $query->getRowArray();
    }
}