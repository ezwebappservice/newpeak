<?php
namespace App\Models\Admin;



class Model_team_member extends \App\Models\CI3Model 
{

	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_team_member'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function show() {
        $sql = "SELECT * 
                FROM tbl_team_member t1
                JOIN tbl_lang t2
                ON t1.lang_id = t2.lang_id
                ORDER BY id ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }


    function add($data) {
        $this->db->table('tbl_team_member')->insert($data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('id',$id);
        $this->db->table('tbl_team_member')->update($data);
    }

    function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->table('tbl_team_member')->delete();
    }

    function get_team_member($id)
    {
        $sql = 'SELECT * FROM tbl_team_member WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function team_member_check($id)
    {
        $sql = 'SELECT * FROM tbl_team_member WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }
   
}