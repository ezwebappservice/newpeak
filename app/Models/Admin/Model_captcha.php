<?php
namespace App\Models\Admin;




class Model_captcha extends \App\Models\CI3Model 
{
    function show() {
        $sql = "SELECT * FROM tbl_setting_captcha WHERE id=?";
        $query = $this->db->query($sql,[1]);
        return $query->getRowArray();
    }

    function show_all() {
        $sql = "SELECT * FROM tbl_captcha";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function add($data) {
        $this->db->table('tbl_captcha')->insert($data);
        return $this->db->insert_id();
    }

    function update($data) {
        $this->db->where('id',1);
        $this->db->table('tbl_setting_captcha')->update($data);
    }

    function captcha_check($id) {
        $sql = 'SELECT * FROM tbl_captcha WHERE captcha_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function delete($id) {
        $this->db->where('captcha_id',$id);
        $this->db->table('tbl_captcha')->delete();
    }
    
}