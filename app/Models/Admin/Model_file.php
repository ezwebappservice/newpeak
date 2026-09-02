<?php
namespace App\Models\Admin;



class Model_file extends \App\Models\CI3Model 
{

	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_file'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
	
    function show() {
        $sql = "SELECT * FROM tbl_file ORDER BY file_id ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function add($data) {
        $this->db->table('tbl_file')->insert($data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('file_id',$id);
        $this->db->table('tbl_file')->update($data);
    }

    function delete($id)
    {
        $this->db->where('file_id',$id);
        $this->db->table('tbl_file')->delete();
    }

    function get_file($id)
    {
        $sql = 'SELECT * FROM tbl_file WHERE file_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function file_check($id)
    {
        $sql = 'SELECT * FROM tbl_file WHERE file_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }
    
}