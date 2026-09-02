<?php

namespace App\Models;

class Model_order extends CI3Model
{
    public function generateOrderNumber(): string
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }

    public function createOrder(array $orderData, array $items): int
    {
        $now = date('Y-m-d H:i:s');
        $orderData['created_at'] = $now;
        $orderData['updated_at'] = $now;
        $this->db->table('tbl_shop_order')->insert($orderData);
        $orderId = (int) $this->db->insert_id();

        foreach ($items as $item) {
            $item['order_id'] = $orderId;
            $this->db->table('tbl_shop_order_item')->insert($item);
        }

        return $orderId;
    }

    public function getById(int $orderId): ?array
    {
        $sql = 'SELECT * FROM tbl_shop_order WHERE order_id=? LIMIT 1';
        $query = $this->db->query($sql, [$orderId]);

        return $query->getRowArray() ?: null;
    }

    public function getByNumber(string $orderNumber): ?array
    {
        $sql = 'SELECT * FROM tbl_shop_order WHERE order_number=? LIMIT 1';
        $query = $this->db->query($sql, [$orderNumber]);

        return $query->getRowArray() ?: null;
    }

    public function getItems(int $orderId): array
    {
        $sql = 'SELECT * FROM tbl_shop_order_item WHERE order_id=?';
        $query = $this->db->query($sql, [$orderId]);

        return $query->getResultArray();
    }

    public function decrementStock(int $productId, int $qty): void
    {
        $sql = 'UPDATE tbl_shop_product SET stock_quantity = GREATEST(0, stock_quantity - ?) WHERE product_id=?';
        $this->db->query($sql, [$qty, $productId]);
    }
}
