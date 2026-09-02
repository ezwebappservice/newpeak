<?php
namespace App\Models;



class Model_testimonial extends \App\Models\CI3Model 
{
    public function all_testimonial()
    {
        $query = $this->db->query("SELECT * FROM tbl_testimonial WHERE lang_id=? ORDER BY id ASC", [$_SESSION['sess_lang_id']]);
        return $query->getResultArray();
    }
}