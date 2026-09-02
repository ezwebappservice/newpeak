<?php

namespace App\Models;

class Model_nav_menu extends \App\Models\CI3Model
{
    protected function currentLangId(): int
    {
        return (int) ($_SESSION['sess_lang_id'] ?? 5);
    }

    public function visible_rows(?int $langId = null): array
    {
        $langId = $langId ?? $this->currentLangId();

        $query = $this->db->query(
            'SELECT * FROM tbl_nav_menu WHERE lang_id = ? AND menu_status = ? ORDER BY parent_id ASC, sort_order ASC, id ASC',
            [$langId, 'Show']
        );
        $rows = $query->getResultArray();

        if ($rows !== []) {
            return $rows;
        }

        $query = $this->db->query(
            'SELECT * FROM tbl_nav_menu WHERE menu_status = ? ORDER BY parent_id ASC, sort_order ASC, id ASC',
            ['Show']
        );

        return $query->getResultArray();
    }

    public function navigation_tree(?int $langId = null): array
    {
        $rows = $this->visible_rows($langId);

        if ($rows === []) {
            return [];
        }

        helper('nav_menu');

        return nav_menu_build_tree($rows);
    }

    public function meta_for_slug(string $slug, ?int $langId = null): ?array
    {
        if ($slug === '') {
            return null;
        }

        $langId = $langId ?? $this->currentLangId();

        $query = $this->db->query(
            'SELECT meta_title, meta_keyword, meta_description FROM tbl_nav_menu
             WHERE slug = ? AND lang_id = ? AND menu_status = ? LIMIT 1',
            [$slug, $langId, 'Show']
        );
        $row = $query->getRowArray();

        if ($row) {
            return $row;
        }

        $query = $this->db->query(
            'SELECT meta_title, meta_keyword, meta_description FROM tbl_nav_menu
             WHERE slug = ? AND menu_status = ? LIMIT 1',
            [$slug, 'Show']
        );

        return $query->getRowArray();
    }
}
