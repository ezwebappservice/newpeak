<?php

namespace App\Models;

class Model_workshop_registration extends CI3Model
{
    public function add(array $data): int
    {
        $this->db->table('tbl_workshop_registration')->insert($data);

        return (int) $this->db->insert_id();
    }

    public function updateById(int $id, array $data): void
    {
        $this->db->where('id', $id);
        $this->db->table('tbl_workshop_registration')->update($data);
    }

    public function findByToken(string $token): ?array
    {
        $row = $this->db->query(
            'SELECT * FROM tbl_workshop_registration WHERE public_token = ?',
            [$token]
        )->getRowArray();

        return $row ?: null;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function all(?string $status = null): array
    {
        $db = \Config\Database::connect();

        if (! $db->tableExists('tbl_workshop_registration')) {
            return [];
        }

        $sql = 'SELECT * FROM tbl_workshop_registration WHERE 1=1';
        $params = [];

        if ($status !== null && $status !== '') {
            $sql .= ' AND payment_status = ?';
            $params[] = $status;
        }

        $sql .= ' ORDER BY created_at DESC, id DESC';

        return $this->db->query($sql, $params)->getResultArray();
    }

    public function countPaid(): int
    {
        $db = \Config\Database::connect();

        if (! $db->tableExists('tbl_workshop_registration')) {
            return 0;
        }

        return (int) $db->table('tbl_workshop_registration')->where('payment_status', 'paid')->countAllResults();
    }
}
