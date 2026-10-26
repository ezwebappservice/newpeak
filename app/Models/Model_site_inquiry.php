<?php

namespace App\Models;

class Model_site_inquiry extends \App\Models\CI3Model
{
    public function add(array $data): int
    {
        $db = \Config\Database::connect();

        if (! $db->tableExists('tbl_site_inquiry')) {
            throw new \RuntimeException('Inquiry table is not available.');
        }

        if (! $db->fieldExists('form_data', 'tbl_site_inquiry')) {
            unset($data['form_data']);
        }

        $this->db->table('tbl_site_inquiry')->insert($data);

        return (int) $this->db->insert_id();
    }

    public function updateById(int $id, array $data): void
    {
        $this->db->where('id', $id);
        $this->db->table('tbl_site_inquiry')->update($data);
    }

    public function findDiscoveryByToken(string $token): ?array
    {
        if ($token === '') {
            return null;
        }

        $row = $this->db->query(
            "SELECT * FROM tbl_site_inquiry WHERE form_source = 'discovery' AND JSON_UNQUOTE(JSON_EXTRACT(form_data, '$.public_token')) = ? LIMIT 1",
            [$token]
        )->getRowArray();

        return $row ?: null;
    }
}
