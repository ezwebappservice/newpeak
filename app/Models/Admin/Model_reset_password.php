<?php
namespace App\Models\Admin;



class Model_reset_password extends \App\Models\CI3Model 
{

    public function get_setting_data()
    {
        $query = $this->db->query("SELECT * from tbl_settings WHERE id=1");
        return $query->getRowArray();
    }

    function check_url($userId, $token) {
        helper('security');

        $query = $this->db->query(
            "SELECT * from tbl_user WHERE id=? AND token=?",
            [(int) $userId, $token]
        );
        $row = $query->getRowArray();

        if (! $row) {
            return null;
        }

        if (! admin_reset_token_valid($token)) {
            return null;
        }

        return $row;
    }

    function update($userId, $data) {
        $this->db->where('id', (int) $userId);
        $this->db->table('tbl_user')->update($data);
    }
}
