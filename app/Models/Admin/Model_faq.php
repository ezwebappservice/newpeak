<?php
namespace App\Models\Admin;




class Model_faq extends \App\Models\CI3Model 
{

	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_faq'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
	
    function show() {
        $sql = "SELECT * 
                FROM tbl_faq t1
                JOIN tbl_lang t2
                ON t1.lang_id = t2.lang_id
                ORDER BY t1.faq_id ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function add($data) {
        $this->db->table('tbl_faq')->insert($data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('faq_id',$id);
        $this->db->table('tbl_faq')->update($data);
    }

    function delete($id)
    {
        $this->db->where('faq_id',$id);
        $this->db->table('tbl_faq')->delete();
    }

    function getData($id)
    {
        $sql = 'SELECT * FROM tbl_faq WHERE faq_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function faq_check($id)
    {
        $sql = 'SELECT * FROM tbl_faq WHERE faq_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function get_photo()
    {
        $sql = 'SELECT * FROM tbl_faq_photo WHERE id=?';
        $query = $this->db->query($sql,array(1));
        return $query->getRowArray();
    }
    function update_faq_photo($data) {
        $this->db->where('id',1);
        $this->db->table('tbl_faq_photo')->update($data);
    }
    
}