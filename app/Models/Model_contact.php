<?php
namespace App\Models;



class Model_contact extends \App\Models\CI3Model 
{
    public function all_testimonial()
    {
        $query = $this->db->query("SELECT * FROM tbl_testimonial ORDER BY id ASC");
        return $query->getResultArray();
    }

    public function check_captcha()
    {
    	$query = $this->db->query("SELECT * FROM tbl_setting_captcha WHERE id=?",[1]);
        return $query->getRowArray();
    }

    public function total_captcha()
    {
    	$query = $this->db->query("SELECT * FROM tbl_captcha");
        return $query->getNumRows();
    }

    public function get_particular_captcha($id)
    {
    	$query = $this->db->query("SELECT * FROM tbl_captcha WHERE captcha_id=?",[$id]);
        return $query->getRowArray();
    }

    public function active_locations()
    {
        $query = $this->db->query(
            "SELECT id, title, address FROM tbl_contact_locations
             WHERE lang_id = ? AND status = 'Active'
             ORDER BY sort_order ASC, id ASC",
            [$_SESSION['sess_lang_id']]
        );

        return $query->getResultArray();
    }
}