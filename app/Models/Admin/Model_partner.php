<?php
namespace App\Models\Admin;



class Model_partner extends \App\Models\CI3Model 
{

	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_partner'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
	
    function show() {
        $sql = "SELECT * FROM tbl_partner";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function add($data) {
        $this->db->table('tbl_partner')->insert($data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('id',$id);
        $this->db->table('tbl_partner')->update($data);
    }

    function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->table('tbl_partner')->delete();
    }

    function getData($id)
    {
        $sql = 'SELECT * FROM tbl_partner WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function partner_check($id)
    {
        $sql = 'SELECT * FROM tbl_partner WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }
    
}