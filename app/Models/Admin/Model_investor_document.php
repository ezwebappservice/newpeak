<?php

namespace App\Models\Admin;

class Model_investor_document extends \App\Models\CI3Model
{
    public function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'investor_documents'";
        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    /**
     * @param array<string, mixed> $filters
     */
    public function show($filters = [])
    {
        $sql = 'SELECT d.*, c.category_name
                FROM investor_documents d
                INNER JOIN investor_categories c ON c.id = d.category_id
                WHERE 1=1';
        $params = $this->buildFilterSql($filters, $sql);

        $sort = $filters['sort'] ?? 'created_at';
        $order = strtolower($filters['order'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
        $allowedSort = ['file_title', 'title_type', 'year', 'document_type', 'status', 'created_at', 'category_name', 'file_size'];
        $sortColumn = in_array($sort, $allowedSort, true) ? $sort : 'created_at';

        if ($sortColumn === 'category_name') {
            $sql .= ' ORDER BY c.category_name ' . $order . ', d.created_at DESC';
        } else {
            $sql .= ' ORDER BY d.' . $sortColumn . ' ' . $order;
        }

        $query = $this->db->query($sql, $params);

        return $query->getResultArray();
    }

    /**
     * @param array<string, mixed> $filters
     */
    public function count_filtered($filters = [])
    {
        $sql = 'SELECT COUNT(*) AS total
                FROM investor_documents d
                INNER JOIN investor_categories c ON c.id = d.category_id
                WHERE 1=1';
        $params = $this->buildFilterSql($filters, $sql);
        $query = $this->db->query($sql, $params);
        $row = $query->getRowArray();

        return (int) ($row['total'] ?? 0);
    }

    /**
     * @param array<string, mixed> $filters
     */
    public function fetch_paginated($filters = [], $limit = 10, $offset = 0)
    {
        $filters['limit'] = $limit;
        $filters['offset'] = $offset;

        $sql = 'SELECT d.*, c.category_name
                FROM investor_documents d
                INNER JOIN investor_categories c ON c.id = d.category_id
                WHERE 1=1';
        $params = $this->buildFilterSql($filters, $sql);

        $sort = $filters['sort'] ?? 'created_at';
        $order = strtolower($filters['order'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
        $allowedSort = ['file_title', 'title_type', 'year', 'document_type', 'status', 'created_at', 'category_name', 'file_size'];
        $sortColumn = in_array($sort, $allowedSort, true) ? $sort : 'created_at';

        if ($sortColumn === 'category_name') {
            $sql .= ' ORDER BY c.category_name ' . $order . ', d.created_at DESC';
        } else {
            $sql .= ' ORDER BY d.' . $sortColumn . ' ' . $order;
        }

        $sql .= ' LIMIT ? OFFSET ?';
        $params[] = (int) $limit;
        $params[] = (int) $offset;

        $query = $this->db->query($sql, $params);

        return $query->getResultArray();
    }

    /**
     * @param array<string, mixed> $filters
     */
    private function buildFilterSql($filters, &$sql)
    {
        $params = [];

        if (! empty($filters['keyword'])) {
            $sql .= ' AND d.file_title LIKE ?';
            $params[] = '%' . $filters['keyword'] . '%';
        }

        if (! empty($filters['category_id'])) {
            $sql .= ' AND d.category_id = ?';
            $params[] = (int) $filters['category_id'];
        }

        if (! empty($filters['year'])) {
            $sql .= ' AND d.year = ?';
            $params[] = $filters['year'];
        }

        if (! empty($filters['document_type'])) {
            $sql .= ' AND d.document_type = ?';
            $params[] = $filters['document_type'];
        }

        if (! empty($filters['status'])) {
            $sql .= ' AND d.status = ?';
            $params[] = $filters['status'] === 'Inactive' ? 'Inactive' : 'Active';
        }

        if (isset($filters['active_only']) && $filters['active_only']) {
            $sql .= " AND d.status = 'Active' AND c.status = 'Active'";
        }

        return $params;
    }

    public function add($data)
    {
        $this->db->table('investor_documents')->insert($data);

        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->table('investor_documents')->update($data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->table('investor_documents')->delete();
    }

    public function getData($id)
    {
        $sql = 'SELECT d.*, c.category_name
                FROM investor_documents d
                INNER JOIN investor_categories c ON c.id = d.category_id
                WHERE d.id = ?';
        $query = $this->db->query($sql, [$id]);

        return $query->getRowArray();
    }

    public function investor_document_check($id)
    {
        $this->db->select('*');
        $this->db->from('investor_documents');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->getRowArray();
    }

    public function distinct_years($categoryId = null, $activeOnly = false)
    {
        $sql = 'SELECT DISTINCT d.year FROM investor_documents d';
        $params = [];

        if ($activeOnly) {
            $sql .= ' INNER JOIN investor_categories c ON c.id = d.category_id';
        }

        $sql .= ' WHERE 1=1';

        if ($activeOnly) {
            $sql .= " AND d.status = 'Active' AND c.status = 'Active'";
        }

        if ($categoryId) {
            $sql .= ' AND d.category_id = ?';
            $params[] = (int) $categoryId;
        }

        $sql .= ' ORDER BY d.year DESC';
        $query = $this->db->query($sql, $params);
        $rows = $query->getResultArray();

        return array_column($rows, 'year');
    }

    public function distinct_document_types($categoryId = null, $year = null, $activeOnly = false)
    {
        $sql = 'SELECT DISTINCT d.document_type FROM investor_documents d';
        $params = [];

        if ($activeOnly) {
            $sql .= ' INNER JOIN investor_categories c ON c.id = d.category_id';
        }

        $sql .= " WHERE d.document_type IS NOT NULL AND d.document_type != ''";

        if ($activeOnly) {
            $sql .= " AND d.status = 'Active' AND c.status = 'Active'";
        }

        if ($categoryId) {
            $sql .= ' AND d.category_id = ?';
            $params[] = (int) $categoryId;
        }

        if ($year) {
            $sql .= ' AND d.year = ?';
            $params[] = $year;
        }

        $sql .= ' ORDER BY d.document_type ASC';
        $query = $this->db->query($sql, $params);
        $rows = $query->getResultArray();

        return array_column($rows, 'document_type');
    }
}
