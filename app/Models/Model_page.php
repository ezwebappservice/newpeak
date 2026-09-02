<?php

namespace App\Models;

class Model_page extends \App\Models\CI3Model
{
    protected function currentLangId(): int
    {
        return (int) ($_SESSION['sess_lang_id'] ?? 5);
    }

    protected function applyActiveFilter()
    {
        $this->db->where('status', 'Active');
    }

    public function page_check($slug)
    {
        $this->db->select('id');
        $this->db->from('tbl_page_dynamic');
        $this->db->where('slug', $slug);
        $this->db->where('lang_id', $this->currentLangId());
        $this->applyActiveFilter();
        $query = $this->db->get();

        if ($query->getNumRows() > 0) {
            return $query->getNumRows();
        }

        $this->db->select('id');
        $this->db->from('tbl_page_dynamic');
        $this->db->where('slug', $slug);
        $this->applyActiveFilter();
        $query = $this->db->get();

        return $query->getNumRows();
    }

    public function dynamic_page_by_slug($slug)
    {
        $this->db->select('*');
        $this->db->from('tbl_page_dynamic');
        $this->db->where('slug', $slug);
        $this->db->where('lang_id', $this->currentLangId());
        $this->applyActiveFilter();
        $query = $this->db->get();
        $row = $query->getRowArray();

        if ($row) {
            return $row;
        }

        $this->db->select('*');
        $this->db->from('tbl_page_dynamic');
        $this->db->where('slug', $slug);
        $this->applyActiveFilter();
        $query = $this->db->get();

        return $query->getRowArray();
    }

    /**
     * @return array<string, bool> slug => true
     */
    public function active_slugs(): array
    {
        $this->db->select('slug');
        $this->db->from('tbl_page_dynamic');
        $this->db->where('lang_id', $this->currentLangId());
        $this->applyActiveFilter();
        $query = $this->db->get();
        $rows = $query->getResultArray();

        if (empty($rows)) {
            $this->db->select('slug');
            $this->db->from('tbl_page_dynamic');
            $this->applyActiveFilter();
            $query = $this->db->get();
            $rows = $query->getResultArray();
        }

        $map = [];
        foreach ($rows as $row) {
            $map[$row['slug']] = true;
        }

        return $map;
    }

    public function all_for_navigation(): array
    {
        $langId = $this->currentLangId();
        $query = $this->db->query(
            'SELECT slug, name FROM tbl_page_dynamic WHERE lang_id = ? AND status = ? ORDER BY name ASC',
            [$langId, 'Active']
        );
        $rows = $query->getResultArray();

        if ($rows !== []) {
            return $rows;
        }

        $query = $this->db->query(
            'SELECT slug, name FROM tbl_page_dynamic WHERE status = ? ORDER BY name ASC',
            ['Active']
        );

        return $query->getResultArray();
    }
}
