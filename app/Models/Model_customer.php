<?php

namespace App\Models;

class Model_customer extends CI3Model
{
    public function getByEmail(string $email): ?array
    {
        $sql = 'SELECT * FROM tbl_shop_customer WHERE email=? AND status=1 LIMIT 1';
        $query = $this->db->query($sql, [$email]);

        return $query->getRowArray() ?: null;
    }

    public function getById(int $customerId): ?array
    {
        $sql = 'SELECT * FROM tbl_shop_customer WHERE customer_id=? AND status=1 LIMIT 1';
        $query = $this->db->query($sql, [$customerId]);

        return $query->getRowArray() ?: null;
    }

    public function emailExists(string $email, int $excludeId = 0): bool
    {
        $sql = 'SELECT customer_id FROM tbl_shop_customer WHERE email=? AND customer_id!=? LIMIT 1';
        $query = $this->db->query($sql, [$email, $excludeId]);

        return $query->getRowArray() !== null;
    }

    public function create(array $data): int
    {
        $now = date('Y-m-d H:i:s');
        $data['created_at'] = $now;
        $data['updated_at'] = $now;
        $data['status'] = 1;
        $this->db->table('tbl_shop_customer')->insert($data);

        return (int) $this->db->insert_id();
    }

    public function updateProfile(int $customerId, array $data): void
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        unset($data['password'], $data['email'], $data['customer_id']);
        $this->db->table('tbl_shop_customer')->where('customer_id', $customerId)->update($data);
    }

    public function updatePassword(int $customerId, string $hash): void
    {
        $this->db->table('tbl_shop_customer')->where('customer_id', $customerId)->update([
            'password'   => $hash,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function verifyLogin(string $email, string $password): ?array
    {
        $customer = $this->getByEmail($email);
        if (! $customer) {
            return null;
        }

        if (! password_verify($password, $customer['password'])) {
            return null;
        }

        return $customer;
    }
}
