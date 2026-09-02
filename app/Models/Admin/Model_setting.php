<?php
namespace App\Models\Admin;



class Model_setting extends \App\Models\CI3Model 
{
    public function update($data)
	{
        $this->db->where('id',1);
        $this->db->table('tbl_settings')->update($data);
    }
}