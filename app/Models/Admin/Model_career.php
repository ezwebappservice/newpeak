<?php

namespace App\Models\Admin;

class Model_career extends \App\Models\CI3Model
{
    public function show(?int $langId = null): array
    {
        $sql = 'SELECT * FROM tbl_career WHERE 1=1';
        $params = [];

        if ($langId !== null && $langId > 0) {
            $sql .= ' AND lang_id = ?';
            $params[] = $langId;
        }

        $sql .= ' ORDER BY sort_order ASC, job_title ASC';

        return $this->db->query($sql, $params)->getResultArray();
    }

    public function add(array $data): int
    {
        $this->db->table('tbl_career')->insert($data);

        return (int) $this->db->insertID();
    }

    public function update(int $id, array $data): void
    {
        $this->db->where('id', $id);
        $this->db->table('tbl_career')->update($data);
    }

    public function delete(int $id): void
    {
        $this->db->where('id', $id);
        $this->db->table('tbl_career')->delete();
    }

    public function getData(int $id): ?array
    {
        $query = $this->db->query('SELECT * FROM tbl_career WHERE id = ?', [$id]);

        return $query->getRowArray();
    }

    public function career_check(int $id): ?array
    {
        $query = $this->db->query('SELECT * FROM tbl_career WHERE id = ?', [$id]);

        return $query->getRowArray();
    }

    public function next_sort_order(): int
    {
        $query = $this->db->query('SELECT MAX(sort_order) AS max_sort FROM tbl_career');
        $row = $query->getRowArray();

        return (int) ($row['max_sort'] ?? 0) + 1;
    }
}
