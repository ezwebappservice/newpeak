<?php

namespace App\Models\Admin;

class Model_site_inquiry extends \App\Models\CI3Model
{
    public function show(?string $source = null, ?string $status = null): array
    {
        $db = \Config\Database::connect();

        if (! $db->tableExists('tbl_site_inquiry')) {
            return [];
        }
        $sql = 'SELECT * FROM tbl_site_inquiry WHERE 1=1';
        $params = [];

        if ($source !== null && $source !== '') {
            $sql .= ' AND form_source = ?';
            $params[] = $source;
        }

        if ($status !== null && $status !== '') {
            $sql .= ' AND status = ?';
            $params[] = $status;
        }

        $sql .= ' ORDER BY created_at DESC, id DESC';

        return $this->db->query($sql, $params)->getResultArray();
    }

    public function get(int $id): ?array
    {
        $query = $this->db->query('SELECT * FROM tbl_site_inquiry WHERE id = ?', [$id]);

        return $query->getRowArray();
    }

    public function delete(int $id): void
    {
        $this->db->where('id', $id);
        $this->db->table('tbl_site_inquiry')->delete();
    }

    public function mark_read(int $id): void
    {
        $this->db->where('id', $id);
        $this->db->table('tbl_site_inquiry')->update(['status' => 'Read']);
    }

    public function count_new(): int
    {
        $db = \Config\Database::connect();

        if (! $db->tableExists('tbl_site_inquiry')) {
            return 0;
        }

        return (int) $db->table('tbl_site_inquiry')->where('status', 'New')->countAllResults();
    }
}
