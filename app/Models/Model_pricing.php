<?php
namespace App\Models;



class Model_pricing extends \App\Models\CI3Model 
{
    public function all_pricing()
    {
        $query = $this->db->query("SELECT * FROM tbl_pricing_table WHERE lang_id=? ORDER BY id ASC", [$_SESSION['sess_lang_id']]);
        return $query->getResultArray();
    }
}