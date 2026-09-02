<?php
namespace App\Models\Admin;



class Model_client extends \App\Models\CI3Model 
{

	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_client'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
	
    function show() {
        $sql = "SELECT * FROM tbl_client ORDER BY id ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function add($data) {
        $this->db->table('tbl_client')->insert($data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('id',$id);
        $this->db->table('tbl_client')->update($data);
    }

    function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->table('tbl_client')->delete();
    }

    function get_client($id)
    {
        $sql = 'SELECT * FROM tbl_client WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function client_check($id)
    {
        $sql = 'SELECT * FROM tbl_client WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }
    
}