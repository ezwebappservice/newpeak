<?php
namespace App\Models;

class Model_shop extends \App\Models\CI3Model
{
    protected function langId(): int
    {
        return $_SESSION['sess_lang_id'] ?? 1;
    }

    function parent_categories($limit = 0)
    {
        $sql = 'SELECT * FROM tbl_shop_parent_category WHERE lang_id=? AND status=1 ORDER BY sort_order ASC';
        if ($limit > 0) {
            $sql .= ' LIMIT ' . (int) $limit;
        }
        $query = $this->db->query($sql, [$this->langId()]);
        return $query->getResultArray();
    }

    function parent_category_by_slug($slug)
    {
        $sql = 'SELECT * FROM tbl_shop_parent_category WHERE category_slug=? AND lang_id=? AND status=1';
        $query = $this->db->query($sql, [$slug, $this->langId()]);
        return $query->getRowArray();
    }

    function sub_category_by_slug($slug)
    {
        $sql = 'SELECT t1.*, t2.category_name AS parent_name, t2.category_slug AS parent_slug
                FROM tbl_shop_sub_category t1
                JOIN tbl_shop_parent_category t2 ON t1.parent_category_id = t2.parent_category_id
                WHERE t1.category_slug=? AND t1.lang_id=? AND t1.status=1';
        $query = $this->db->query($sql, [$slug, $this->langId()]);
        return $query->getRowArray();
    }

    function sub_categories_by_parent($parent_id)
    {
        $sql = 'SELECT * FROM tbl_shop_sub_category WHERE parent_category_id=? AND lang_id=? AND status=1 ORDER BY sort_order ASC';
        $query = $this->db->query($sql, [$parent_id, $this->langId()]);
        return $query->getResultArray();
    }

    function products_by_parent_category($parent_id, $limit = 0)
    {
        $sql = "SELECT p.* FROM tbl_shop_product p
                JOIN tbl_shop_product_category pc ON p.product_id = pc.product_id
                WHERE pc.parent_category_id=? AND p.lang_id=? AND p.status=1
                ORDER BY p.sort_order ASC, p.product_id DESC";
        if ($limit > 0) {
            $sql .= ' LIMIT ' . (int) $limit;
        }
        $query = $this->db->query($sql, [$parent_id, $this->langId()]);
        return $query->getResultArray();
    }

    function products_by_sub_category($sub_id, $limit = 0)
    {
        $sql = "SELECT p.* FROM tbl_shop_product p
                JOIN tbl_shop_product_category pc ON p.product_id = pc.product_id
                WHERE pc.sub_category_id=? AND p.lang_id=? AND p.status=1
                ORDER BY p.sort_order ASC, p.product_id DESC";
        if ($limit > 0) {
            $sql .= ' LIMIT ' . (int) $limit;
        }
        $query = $this->db->query($sql, [$sub_id, $this->langId()]);
        return $query->getResultArray();
    }

    function product_by_slug($slug)
    {
        $sql = 'SELECT * FROM tbl_shop_product WHERE product_slug=? AND lang_id=? AND status=1';
        $query = $this->db->query($sql, [$slug, $this->langId()]);
        return $query->getRowArray();
    }

    function product_images($product_id)
    {
        $sql = 'SELECT * FROM tbl_shop_product_image WHERE product_id=? ORDER BY sort_order ASC, image_id ASC';
        $query = $this->db->query($sql, [$product_id]);
        return $query->getResultArray();
    }

    function related_products($product_id, $parent_category_id, $limit = 4)
    {
        $sql = "SELECT p.* FROM tbl_shop_product p
                JOIN tbl_shop_product_category pc ON p.product_id = pc.product_id
                WHERE pc.parent_category_id=? AND p.product_id!=? AND p.lang_id=? AND p.status=1
                ORDER BY RAND() LIMIT ?";
        $query = $this->db->query($sql, [$parent_category_id, $product_id, $this->langId(), (int) $limit]);
        return $query->getResultArray();
    }

    function product_category_mapping($product_id)
    {
        $sql = 'SELECT pc.*, sc.category_name AS sub_name, sc.category_slug AS sub_slug,
                       pcat.category_name AS parent_name, pcat.category_slug AS parent_slug
                FROM tbl_shop_product_category pc
                LEFT JOIN tbl_shop_sub_category sc ON pc.sub_category_id = sc.sub_category_id
                LEFT JOIN tbl_shop_parent_category pcat ON pc.parent_category_id = pcat.parent_category_id
                WHERE pc.product_id=? LIMIT 1';
        $query = $this->db->query($sql, [$product_id]);
        return $query->getRowArray();
    }

    function search_products($keyword)
    {
        $keyword = '%' . $keyword . '%';
        $sql = "SELECT * FROM tbl_shop_product
                WHERE lang_id=? AND status=1
                AND (product_name LIKE ? OR short_description LIKE ? OR full_description LIKE ?)
                ORDER BY product_name ASC";
        $query = $this->db->query($sql, [$this->langId(), $keyword, $keyword, $keyword]);
        return $query->getResultArray();
    }

    function all_products($limit = 0)
    {
        $sql = 'SELECT * FROM tbl_shop_product WHERE lang_id=? AND status=1 ORDER BY sort_order ASC, product_id DESC';
        if ($limit > 0) {
            $sql .= ' LIMIT ' . (int) $limit;
        }
        $query = $this->db->query($sql, [$this->langId()]);
        return $query->getResultArray();
    }

    function get_product_by_id($product_id)
    {
        $sql = 'SELECT * FROM tbl_shop_product WHERE product_id=? AND status=1';
        $query = $this->db->query($sql, [$product_id]);
        return $query->getRowArray();
    }
}
