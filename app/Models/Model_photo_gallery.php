<?php
namespace App\Models;



class Model_photo_gallery extends \App\Models\CI3Model 
{
    public function all_photo()
    {
        $query = $this->db->query("SELECT * FROM tbl_photo ORDER BY photo_id ASC");
        return $query->getResultArray();
    }
}