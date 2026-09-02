<?php
namespace App\Models;



class Model_team_member extends \App\Models\CI3Model 
{
    public function all_team_member()
    {
        $query = $this->db->query("SELECT * FROM tbl_team_member ORDER BY id ASC");
        return $query->getResultArray();
    }

    public function team_member_check($id) {
        $sql = 'SELECT * FROM tbl_team_member WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getNumRows();
    }

    public function team_member_detail($id) {
        $sql = 'SELECT * FROM tbl_team_member WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }
}