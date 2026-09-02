<?php

namespace App\Models\Admin;

class Model_api_product extends \App\Models\CI3Model
{
    public function show(string $productType, ?int $langId = null): array
    {
        $sql = 'SELECT p.*
                FROM tbl_api_product p
                WHERE p.product_type = ?';
        $params = [$productType];

        if ($langId !== null && $langId > 0) {
            $sql .= ' AND p.lang_id = ?';
            $params[] = $langId;
        }

        $sql .= ' ORDER BY p.sort_order ASC, p.product_name ASC';

        return $this->db->query($sql, $params)->getResultArray();
    }

    public function add(array $data): int
    {
        $this->db->table('tbl_api_product')->insert($data);

        return (int) $this->db->insertID();
    }

    public function update(int $id, array $data): void
    {
        $this->db->where('id', $id);
        $this->db->table('tbl_api_product')->update($data);
    }

    public function delete(int $id): void
    {
        $this->db->where('id', $id);
        $this->db->table('tbl_api_product')->delete();
    }

    public function getData(int $id): ?array
    {
        $query = $this->db->query('SELECT * FROM tbl_api_product WHERE id = ?', [$id]);

        return $query->getRowArray();
    }

    public function product_check(int $id, string $productType): ?array
    {
        $query = $this->db->query(
            'SELECT * FROM tbl_api_product WHERE id = ? AND product_type = ?',
            [$id, $productType]
        );

        return $query->getRowArray();
    }

    public function next_sort_order(string $productType): int
    {
        $query = $this->db->query(
            'SELECT MAX(sort_order) AS max_sort FROM tbl_api_product WHERE product_type = ?',
            [$productType]
        );
        $row = $query->getRowArray();

        return (int) ($row['max_sort'] ?? 0) + 1;
    }
}
