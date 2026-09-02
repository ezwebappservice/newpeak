<?php
namespace App\Models\Admin;



class Model_why_choose extends \App\Models\CI3Model 
{

	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_why_choose'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
	
    function show() {
        $sql = "SELECT * 
                FROM tbl_why_choose t1
                JOIN tbl_lang t2
                ON t1.lang_id = t2.lang_id";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function add($data) {
        $this->db->table('tbl_why_choose')->insert($data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('id',$id);
        $this->db->table('tbl_why_choose')->update($data);
    }

    function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->table('tbl_why_choose')->delete();
    }

    function getData($id)
    {
        $sql = 'SELECT * FROM tbl_why_choose WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function why_choose_check($id)
    {
        $sql = 'SELECT * FROM tbl_why_choose WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }
    
}