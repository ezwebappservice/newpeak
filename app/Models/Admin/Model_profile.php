<?php
namespace App\Models\Admin;



class Model_profile extends \App\Models\CI3Model 
{

    function update($data, ?int $userId = null) {
        $id = $userId ?? (int) session()->get('id');

        if ($id <= 0) {
            return;
        }

        $this->db->where('id', $id);
        $this->db->table('tbl_user')->update($data);
    }
    
}
