<?php
namespace App\Models;



class Model_faq extends \App\Models\CI3Model 
{
    public function all_faq()
    {
        $query = $this->db->query("SELECT * FROM tbl_faq WHERE lang_id=? ORDER BY faq_id ASC", [$_SESSION['sess_lang_id']]);
        return $query->getResultArray();
    }
}