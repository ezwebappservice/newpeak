<?php

namespace App\Models;

class Model_site_inquiry extends \App\Models\CI3Model
{
    public function add(array $data): int
    {
        $this->db->table('tbl_site_inquiry')->insert($data);

        return (int) $this->db->insertID();
    }
}
