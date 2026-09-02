<?php
namespace App\Models\Admin;




class Model_photo extends \App\Models\CI3Model 
{

	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_photo'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
	
    function show() {
        $sql = "SELECT * FROM tbl_photo ORDER BY photo_id ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function add($data) {
        $this->db->table('tbl_photo')->insert($data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('photo_id',$id);
        $this->db->table('tbl_photo')->update($data);
    }

    function delete($id)
    {
        $this->db->where('photo_id',$id);
        $this->db->table('tbl_photo')->delete();
    }

    function getData($id)
    {
        $sql = 'SELECT * FROM tbl_photo WHERE photo_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function photo_check($id)
    {
        $sql = 'SELECT * FROM tbl_photo WHERE photo_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }
    
}