<?php

namespace App\Models;

class Model_investor extends \App\Models\CI3Model
{
    public function active_categories()
    {
        $sql = "SELECT c.id, c.category_name, c.category_slug, c.parent_id, c.sort_order,
                       p.category_name AS parent_name, p.category_slug AS parent_slug, p.sort_order AS parent_sort_order
                FROM investor_categories c
                LEFT JOIN investor_categories p ON p.id = c.parent_id
                WHERE c.status = 'Active'
                ORDER BY COALESCE(p.sort_order, c.sort_order) ASC, c.parent_id ASC, c.sort_order ASC, c.category_name ASC";
        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function get_by_slug(string $slug)
    {
        $sql = "SELECT c.*, p.category_name AS parent_name, p.category_slug AS parent_slug
                FROM investor_categories c
                LEFT JOIN investor_categories p ON p.id = c.parent_id
                WHERE c.category_slug = ? AND c.status = 'Active'";
        $query = $this->db->query($sql, [$slug]);

        return $query->getRowArray();
    }

    public function active_parent_categories()
    {
        $sql = "SELECT id, category_name, category_slug, sort_order
                FROM investor_categories
                WHERE status = 'Active' AND (parent_id IS NULL OR parent_id = 0)
                ORDER BY sort_order ASC, category_name ASC";
        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function active_children($parentId)
    {
        $sql = "SELECT id, category_name, category_slug, parent_id, sort_order
                FROM investor_categories
                WHERE status = 'Active' AND parent_id = ?
                ORDER BY sort_order ASC, category_name ASC";
        $query = $this->db->query($sql, [(int) $parentId]);

        return $query->getResultArray();
    }

    /**
     * @param array<string, mixed> $filters
     */
    public function get_documents($filters = [], $limit = 10, $offset = 0)
    {
        $sql = 'SELECT d.id, d.category_id, d.year, d.file_title, d.title_type, d.document_type,
                       d.original_file_name, d.file_size, d.created_at, c.category_name,
                       p.category_name AS parent_category_name
                FROM investor_documents d
                INNER JOIN investor_categories c ON c.id = d.category_id
                LEFT JOIN investor_categories p ON p.id = c.parent_id
                WHERE d.status = \'Active\' AND c.status = \'Active\'';
        $params = $this->applyFilters($filters, $sql);

        $sql .= ' ORDER BY d.created_at DESC LIMIT ? OFFSET ?';
        $params[] = (int) $limit;
        $params[] = (int) $offset;

        $query = $this->db->query($sql, $params);

        return $query->getResultArray();
    }

    /**
     * @param array<string, mixed> $filters
     */
    public function count_documents($filters = [])
    {
        $sql = 'SELECT COUNT(*) AS total
                FROM investor_documents d
                INNER JOIN investor_categories c ON c.id = d.category_id
                WHERE d.status = \'Active\' AND c.status = \'Active\'';
        $params = $this->applyFilters($filters, $sql);
        $query = $this->db->query($sql, $params);
        $row = $query->getRowArray();

        return (int) ($row['total'] ?? 0);
    }

    public function get_document($id, $activeOnly = true)
    {
        $sql = 'SELECT d.*, c.category_name, p.category_name AS parent_category_name
                FROM investor_documents d
                INNER JOIN investor_categories c ON c.id = d.category_id
                LEFT JOIN investor_categories p ON p.id = c.parent_id
                WHERE d.id = ?';
        $params = [$id];

        if ($activeOnly) {
            $sql .= " AND d.status = 'Active' AND c.status = 'Active'";
        }

        $query = $this->db->query($sql, $params);

        return $query->getRowArray();
    }

    public function years_for_category($categoryId)
    {
        $sql = "SELECT DISTINCT d.year
                FROM investor_documents d
                INNER JOIN investor_categories c ON c.id = d.category_id
                WHERE d.category_id = ? AND d.status = 'Active' AND c.status = 'Active'
                ORDER BY d.year DESC";
        $query = $this->db->query($sql, [(int) $categoryId]);
        $rows = $query->getResultArray();

        return array_column($rows, 'year');
    }

    public function default_year_for_category($categoryId): string
    {
        $sql = "SELECT d.year
                FROM investor_documents d
                INNER JOIN investor_categories c ON c.id = d.category_id
                WHERE d.category_id = ? AND d.status = 'Active' AND c.status = 'Active'
                ORDER BY d.created_at DESC
                LIMIT 1";
        $query = $this->db->query($sql, [(int) $categoryId]);
        $row = $query->getRowArray();

        return (string) ($row['year'] ?? '');
    }

    public function document_count($categoryId): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM investor_documents d
                INNER JOIN investor_categories c ON c.id = d.category_id
                WHERE d.category_id = ? AND d.status = 'Active' AND c.status = 'Active'";
        $query = $this->db->query($sql, [(int) $categoryId]);
        $row = $query->getRowArray();

        return (int) ($row['total'] ?? 0);
    }

    public function document_types_for_filters($categoryId = null, $year = null)
    {
        $sql = "SELECT DISTINCT d.document_type
                FROM investor_documents d
                INNER JOIN investor_categories c ON c.id = d.category_id
                WHERE d.status = 'Active' AND c.status = 'Active'
                  AND d.document_type IS NOT NULL AND d.document_type != ''";
        $params = [];

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

    /**
     * @param array<string, mixed> $filters
     */
    private function applyFilters($filters, &$sql)
    {
        $params = [];

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

        if (! empty($filters['keyword'])) {
            $sql .= ' AND d.file_title LIKE ?';
            $params[] = '%' . $filters['keyword'] . '%';
        }

        return $params;
    }
}
