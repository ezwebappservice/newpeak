<?php
namespace App\Models\Admin;




class Model_menu extends \App\Models\CI3Model 
{
    function show() {
        $sql = "SELECT * FROM tbl_menu";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function update($menu_id,$data) {
        $this->db->where('menu_id',$menu_id);
        $this->db->table('tbl_menu')->update($data);
    }
    
}