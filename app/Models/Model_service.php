<?php
namespace App\Models;



class Model_service extends \App\Models\CI3Model 
{
    public function all_service()
    {
        $query = $this->db->query("SELECT * FROM tbl_service WHERE lang_id=? ORDER BY id ASC", [$_SESSION['sess_lang_id']]);
        return $query->getResultArray();
    }

    public function service_check($id) {
        $sql = 'SELECT * FROM tbl_service WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getNumRows();
    }

    public function service_detail($id) {
        $sql = 'SELECT * FROM tbl_service WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    public function check_captcha()
    {
        $query = $this->db->query("SELECT * FROM tbl_setting_captcha WHERE id=?",[1]);
        return $query->getRowArray();
    }

    public function total_captcha()
    {
        $query = $this->db->query("SELECT * FROM tbl_captcha");
        return $query->getNumRows();
    }

    public function get_particular_captcha($id)
    {
        $query = $this->db->query("SELECT * FROM tbl_captcha WHERE captcha_id=?",[$id]);
        return $query->getRowArray();
    }
}