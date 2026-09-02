<?php
namespace App\Models;



class Model_newsletter extends \App\Models\CI3Model 
{
    public function total_subscriber_by_email($email)
    {
        $query = $this->db->query("SELECT * FROM tbl_subscriber WHERE subs_email=?",array($email));
        return $query->getNumRows();
    }

    function add($data) {
        $this->db->table('tbl_subscriber')->insert($data);
        return $this->db->insert_id();
    }

    public function check_url($email,$hash) {
        $sql = 'SELECT * FROM tbl_subscriber WHERE subs_email=? AND subs_hash=?';
        $query = $this->db->query($sql,array($email,$hash));
        return $query->getNumRows();
    }

    public function update($email,$hash,$data) {
        $this->db->where('subs_email',$email);
        $this->db->where('subs_hash',$hash);
        $this->db->table('tbl_subscriber')->update($data);
    }
}