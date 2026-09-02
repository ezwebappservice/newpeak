<?php

namespace App\Models\Admin;

class Model_investor_category extends \App\Models\CI3Model
{
    public function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'investor_categories'";
        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    /**
     * @param string $search
     * @param string $sort  category_name|status|created_at|parent_name|sort_order
     * @param string $order asc|desc
     */
    public function show($search = '', $sort = 'sort_order', $order = 'asc')
    {
        $allowedSort = ['category_name', 'status', 'created_at', 'id', 'parent_name', 'sort_order'];
        $sort = in_array($sort, $allowedSort, true) ? $sort : 'sort_order';
        $order = strtolower($order) === 'desc' ? 'DESC' : 'ASC';

        $sql = 'SELECT c.*, p.category_name AS parent_name
                FROM investor_categories c
                LEFT JOIN investor_categories p ON p.id = c.parent_id
                WHERE 1=1';
        $params = [];

        if ($search !== '') {
            $sql .= ' AND (c.category_name LIKE ? OR p.category_name LIKE ?)';
            $params[] = '%' . $search . '%';
            $params[] = '%' . $search . '%';
        }

        if ($sort === 'parent_name') {
            $sql .= ' ORDER BY p.category_name ' . $order . ', c.sort_order ASC, c.category_name ASC';
        } elseif ($sort === 'sort_order') {
            $sql .= ' ORDER BY COALESCE(p.sort_order, c.sort_order) ' . $order . ', c.parent_id ASC, c.sort_order ' . $order . ', c.category_name ASC';
        } else {
            $sql .= ' ORDER BY c.' . $sort . ' ' . $order;
        }

        $query = $this->db->query($sql, $params);

        return $query->getResultArray();
    }

    public function next_sort_order(?int $parentId = null): int
    {
        if ($parentId !== null && $parentId > 0) {
            $sql = 'SELECT MAX(sort_order) AS max_sort FROM investor_categories WHERE parent_id = ?';
            $params = [$parentId];
        } else {
            $sql = 'SELECT MAX(sort_order) AS max_sort FROM investor_categories WHERE parent_id IS NULL OR parent_id = 0';
            $params = [];
        }

        $query = $this->db->query($sql, $params);
        $row = $query->getRowArray();

        return (int) ($row['max_sort'] ?? 0) + 1;
    }

    public function active_list()
    {
        $sql = "SELECT c.*, p.category_name AS parent_name
                FROM investor_categories c
                LEFT JOIN investor_categories p ON p.id = c.parent_id
                WHERE c.status = 'Active'
                ORDER BY COALESCE(p.sort_order, c.sort_order) ASC, c.parent_id ASC, c.sort_order ASC, c.category_name ASC";
        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function parent_options(?int $excludeId = null): array
    {
        $sql = "SELECT id, category_name, sort_order
                FROM investor_categories
                WHERE status = 'Active' AND (parent_id IS NULL OR parent_id = 0)
                ORDER BY sort_order ASC, category_name ASC";
        $query = $this->db->query($sql);
        $rows = $query->getResultArray();

        if ($excludeId === null) {
            return $rows;
        }

        $blocked = $this->blocked_parent_ids($excludeId);

        return array_values(array_filter($rows, static function ($row) use ($blocked) {
            return ! in_array((int) $row['id'], $blocked, true);
        }));
    }

    public function assignable_list(): array
    {
        $rows = $this->active_list();
        $childrenByParent = [];

        foreach ($rows as $row) {
            $parentId = (int) ($row['parent_id'] ?? 0);

            if ($parentId > 0) {
                $childrenByParent[$parentId][] = $row;
            }
        }

        $assignable = [];

        foreach ($rows as $row) {
            $id = (int) $row['id'];
            $parentId = (int) ($row['parent_id'] ?? 0);
            $hasChildren = ! empty($childrenByParent[$id]);

            if ($parentId > 0 || ! $hasChildren) {
                $assignable[] = $row;
            }
        }

        return $assignable;
    }

    public function add($data)
    {
        $this->db->table('investor_categories')->insert($data);

        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->table('investor_categories')->update($data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->table('investor_categories')->delete();
    }

    public function getData($id)
    {
        $sql = 'SELECT c.*, p.category_name AS parent_name
                FROM investor_categories c
                LEFT JOIN investor_categories p ON p.id = c.parent_id
                WHERE c.id = ?';
        $query = $this->db->query($sql, [(int) $id]);

        return $query->getRowArray();
    }

    public function investor_category_check($id)
    {
        return $this->getData($id);
    }

    public function get_by_slug(string $slug)
    {
        $sql = 'SELECT c.*, p.category_name AS parent_name, p.category_slug AS parent_slug
                FROM investor_categories c
                LEFT JOIN investor_categories p ON p.id = c.parent_id
                WHERE c.category_slug = ? AND c.status = \'Active\'';
        $query = $this->db->query($sql, [$slug]);

        return $query->getRowArray();
    }

    public function slug_exists(string $slug, ?int $excludeId = null): bool
    {
        $sql = 'SELECT COUNT(*) AS total FROM investor_categories WHERE category_slug = ?';
        $params = [$slug];

        if ($excludeId !== null) {
            $sql .= ' AND id != ?';
            $params[] = $excludeId;
        }

        $query = $this->db->query($sql, $params);
        $row = $query->getRowArray();

        return (int) ($row['total'] ?? 0) > 0;
    }

    public function name_exists($name, $excludeId = null)
    {
        $sql = 'SELECT COUNT(*) AS total FROM investor_categories WHERE category_name = ?';
        $params = [$name];

        if ($excludeId !== null) {
            $sql .= ' AND id != ?';
            $params[] = $excludeId;
        }

        $query = $this->db->query($sql, $params);
        $row = $query->getRowArray();

        return (int) ($row['total'] ?? 0) > 0;
    }

    public function document_count($categoryId)
    {
        $sql = 'SELECT COUNT(*) AS total FROM investor_documents WHERE category_id = ?';
        $query = $this->db->query($sql, [$categoryId]);
        $row = $query->getRowArray();

        return (int) ($row['total'] ?? 0);
    }

    public function child_count($categoryId): int
    {
        $sql = 'SELECT COUNT(*) AS total FROM investor_categories WHERE parent_id = ?';
        $query = $this->db->query($sql, [(int) $categoryId]);
        $row = $query->getRowArray();

        return (int) ($row['total'] ?? 0);
    }

    public function is_valid_parent(?int $parentId, ?int $categoryId = null): bool
    {
        if ($parentId === null || $parentId <= 0) {
            return true;
        }

        $parent = $this->investor_category_check($parentId);

        if (! $parent || ($parent['status'] ?? '') !== 'Active') {
            return false;
        }

        if (! empty($parent['parent_id'])) {
            return false;
        }

        if ($categoryId !== null && in_array($parentId, $this->blocked_parent_ids($categoryId), true)) {
            return false;
        }

        return true;
    }

    /**
     * @return list<int>
     */
    public function blocked_parent_ids(int $categoryId): array
    {
        $blocked = [$categoryId];
        $children = $this->db->query(
            'SELECT id FROM investor_categories WHERE parent_id = ?',
            [$categoryId]
        )->getResultArray();

        foreach ($children as $child) {
            $blocked[] = (int) $child['id'];
        }

        return $blocked;
    }
}
