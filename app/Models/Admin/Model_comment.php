<?php
namespace App\Models\Admin;




class Model_comment extends \App\Models\CI3Model 
{

    function show() {
        $sql = "SELECT * FROM tbl_comment WHERE id=?";
        $query = $this->db->query($sql,array(1));
        return $query->getRowArray();
    }

    function update($data) {
        $this->db->where('id',1);
        $this->db->table('tbl_comment')->update($data);
    }
    
}