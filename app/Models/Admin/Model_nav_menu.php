<?php

namespace App\Models\Admin;

class Model_nav_menu extends \App\Models\CI3Model
{
    public function show(?int $langId = null): array
    {
        $sql = 'SELECT t1.*, t2.lang_name FROM tbl_nav_menu t1 JOIN tbl_lang t2 ON t1.lang_id = t2.lang_id';
        $params = [];

        if ($langId !== null) {
            $sql .= ' WHERE t1.lang_id = ?';
            $params[] = $langId;
        }

        $sql .= ' ORDER BY t1.parent_id ASC, t1.sort_order ASC, t1.id ASC';

        return $this->db->query($sql, $params)->getResultArray();
    }

    public function add(array $data): int
    {
        $this->db->table('tbl_nav_menu')->insert($data);

        return (int) $this->db->insertID();
    }

    public function update(int $id, array $data): void
    {
        $this->db->where('id', $id);
        $this->db->table('tbl_nav_menu')->update($data);
    }

    public function delete(int $id): void
    {
        $this->db->where('id', $id);
        $this->db->table('tbl_nav_menu')->delete();
    }

    public function getData(int $id): ?array
    {
        $query = $this->db->query('SELECT * FROM tbl_nav_menu WHERE id = ?', [$id]);

        return $query->getRowArray();
    }

    public function nav_menu_check(int $id): ?array
    {
        return $this->getData($id);
    }

    public function child_count(int $id): int
    {
        return (int) $this->db->table('tbl_nav_menu')->where('parent_id', $id)->countAllResults();
    }

    public function parent_options(int $langId, ?int $excludeId = null): array
    {
        $rows = $this->show($langId);
        $options = [['id' => 0, 'label' => '— Top Level —']];

        foreach ($rows as $row) {
            if ($excludeId !== null && (int) $row['id'] === $excludeId) {
                continue;
            }
            $options[] = [
                'id'    => (int) $row['id'],
                'label' => $this->indentLabel($rows, (int) $row['id']),
            ];
        }

        return $options;
    }

    private function indentLabel(array $rows, int $id): string
    {
        $map = [];
        foreach ($rows as $row) {
            $map[(int) $row['id']] = $row;
        }

        $parts = [];
        $current = $map[$id] ?? null;
        while ($current) {
            array_unshift($parts, $current['label']);
            $parentId = (int) ($current['parent_id'] ?? 0);
            $current = $parentId > 0 ? ($map[$parentId] ?? null) : null;
        }

        return implode(' › ', $parts);
    }
}
