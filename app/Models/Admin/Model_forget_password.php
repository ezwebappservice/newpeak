<?php
namespace App\Models\Admin;



class Model_forget_password extends \App\Models\CI3Model 
{

    public function get_setting_data()
    {
        $query = $this->db->query("SELECT * from tbl_settings WHERE id=1");
        return $query->getRowArray();
    }

    function check_email($email) {
        $sql = "SELECT * FROM tbl_user WHERE email=?";
        $query = $this->db->query($sql,array($email));
        return $query->getRowArray();
    }

    function update($email,$data) {
        $this->db->where('email',$email);
        $this->db->table('tbl_user')->update($data);
    }

}