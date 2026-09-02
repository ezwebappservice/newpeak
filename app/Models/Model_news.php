<?php

namespace App\Models;

class Model_news extends \App\Models\CI3Model
{
    public function all_news()
    {
        $query = $this->db->query("SELECT * 
                        FROM tbl_news t1
                        JOIN tbl_category t2
                        ON t1.category_id = t2.category_id
                        WHERE t1.lang_id=?
                        ORDER BY t1.news_id DESC", [$_SESSION['sess_lang_id']]);

        return $query->getResultArray();
    }

    public function get_total_news()
    {
        $sql = 'SELECT COUNT(*) AS total FROM tbl_news WHERE lang_id=?';
        $query = $this->db->query($sql, [$_SESSION['sess_lang_id']]);
        $row = $query->getRowArray();

        return (int) ($row['total'] ?? 0);
    }

    public function fetch_news($limit, $start)
    {
        $sql = 'SELECT t1.*, t2.category_name
                FROM tbl_news t1
                JOIN tbl_category t2 ON t1.category_id = t2.category_id
                WHERE t1.lang_id = ?
                ORDER BY t1.news_date DESC, t1.news_id DESC
                LIMIT ? OFFSET ?';
        $query = $this->db->query($sql, [$_SESSION['sess_lang_id'], (int) $limit, (int) $start]);

        return $query->getResultArray();
    }

    public function recent_news(int $limit = 4, ?int $excludeId = null): array
    {
        $sql = 'SELECT t1.*, t2.category_name
                FROM tbl_news t1
                JOIN tbl_category t2 ON t1.category_id = t2.category_id
                WHERE t1.lang_id = ?';
        $params = [$_SESSION['sess_lang_id']];

        if ($excludeId !== null) {
            $sql .= ' AND t1.news_id != ?';
            $params[] = $excludeId;
        }

        $sql .= ' ORDER BY t1.news_date DESC, t1.news_id DESC LIMIT ?';
        $params[] = $limit;
        $query = $this->db->query($sql, $params);

        return $query->getResultArray();
    }

    public function all_categories()
    {
        $query = $this->db->query("SELECT * FROM tbl_category ORDER BY category_name ASC");

        return $query->getResultArray();
    }

    public function news_check($id)
    {
        $sql = 'SELECT * FROM tbl_news WHERE news_id=?';
        $query = $this->db->query($sql, [$id]);

        return $query->getNumRows();
    }

    public function news_detail($id)
    {
        $sql = 'SELECT * FROM tbl_news WHERE news_id=?';
        $query = $this->db->query($sql, [$id]);

        return $query->getRowArray();
    }

    public function news_detail_by_slug(string $slug)
    {
        $sql = 'SELECT t1.*, t2.category_name
                FROM tbl_news t1
                JOIN tbl_category t2 ON t1.category_id = t2.category_id
                WHERE t1.news_slug = ? AND t1.lang_id = ?';
        $query = $this->db->query($sql, [$slug, $_SESSION['sess_lang_id']]);

        return $query->getRowArray();
    }

    public function news_detail_with_category($id)
    {
        $sql = 'SELECT t1.*, t2.category_name
                FROM tbl_news t1
                JOIN tbl_category t2 ON t1.category_id = t2.category_id
                WHERE t1.news_id = ?';
        $query = $this->db->query($sql, [$id]);

        return $query->getRowArray();
    }

    public function slug_exists(string $slug, ?int $excludeId = null): bool
    {
        $builder = $this->db->table('tbl_news')->where('news_slug', $slug);

        if ($excludeId !== null) {
            $builder->where('news_id !=', $excludeId);
        }

        return $builder->countAllResults() > 0;
    }

    public function get_category_name_by_id($cat_id)
    {
        $sql = 'SELECT * FROM tbl_category WHERE category_id=?';
        $query = $this->db->query($sql, [$cat_id]);

        return $query->getRowArray();
    }
}
