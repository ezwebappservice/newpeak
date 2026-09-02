<?php
namespace App\Models\Admin;



class Model_category extends \App\Models\CI3Model 
{
	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_category'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function show() {
        $sql = "SELECT * 
                FROM tbl_category t1
                JOIN tbl_lang t2
                ON t1.lang_id = t2.lang_id
                ORDER BY t1.category_id ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function add($data) {
        $this->db->table('tbl_category')->insert($data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('category_id',$id);
        $this->db->table('tbl_category')->update($data);
    }

    function delete($id)
    {
        $this->db->where('category_id',$id);
        $this->db->table('tbl_category')->delete();
    }

    function get_category($id)
    {
        $sql = 'SELECT * FROM tbl_category WHERE category_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function category_check($id)
    {
        $sql = 'SELECT * FROM tbl_category WHERE category_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function check_news($id) {
        $sql = 'SELECT * FROM tbl_news WHERE category_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getNumRows();
    }
   
}