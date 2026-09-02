<?php

namespace App\Models\Admin;

class Model_shop_order extends \App\Models\CI3Model
{
    public function show()
    {
        $sql = 'SELECT o.*, c.email AS customer_account_email
                FROM tbl_shop_order o
                LEFT JOIN tbl_shop_customer c ON o.customer_id = c.customer_id
                ORDER BY o.order_id DESC';
        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function getById(int $orderId): ?array
    {
        $sql = 'SELECT o.*, c.email AS customer_account_email
                FROM tbl_shop_order o
                LEFT JOIN tbl_shop_customer c ON o.customer_id = c.customer_id
                WHERE o.order_id=? LIMIT 1';
        $query = $this->db->query($sql, [$orderId]);

        return $query->getRowArray() ?: null;
    }

    public function getItems(int $orderId): array
    {
        $sql = 'SELECT oi.*, p.featured_image
                FROM tbl_shop_order_item oi
                LEFT JOIN tbl_shop_product p ON oi.product_id = p.product_id
                WHERE oi.order_id=?
                ORDER BY oi.order_item_id ASC';
        $query = $this->db->query($sql, [$orderId]);

        return $query->getResultArray();
    }

    public function updateStatus(int $orderId, string $status): void
    {
        $this->db->table('tbl_shop_order')->where('order_id', $orderId)->update([
            'order_status' => $status,
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);
    }

    public function countByStatus(): array
    {
        $sql = 'SELECT order_status, COUNT(*) AS cnt FROM tbl_shop_order GROUP BY order_status';
        $query = $this->db->query($sql);
        $rows = $query->getResultArray();
        $counts = [
            'pending'    => 0,
            'processing' => 0,
            'completed'  => 0,
            'cancelled'  => 0,
            'total'      => 0,
        ];

        foreach ($rows as $row) {
            $counts[$row['order_status']] = (int) $row['cnt'];
            $counts['total'] += (int) $row['cnt'];
        }

        return $counts;
    }

    public function delete(int $orderId): void
    {
        $this->db->table('tbl_shop_order_item')->where('order_id', $orderId)->delete();
        $this->db->table('tbl_shop_order')->where('order_id', $orderId)->delete();
    }
}
