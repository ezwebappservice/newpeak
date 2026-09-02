<?php
namespace App\Models\Admin;




class Model_social_media extends \App\Models\CI3Model 
{

    function show() {
        $sql = "SELECT * FROM tbl_social";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function update($social_name,$data) {
        $this->db->where('social_name',$social_name);
        $this->db->table('tbl_social')->update($data);
    }
    
}