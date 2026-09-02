<?php
namespace App\Models\Admin;

class Model_shop_parent_category extends \App\Models\CI3Model
{
    function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_shop_parent_category'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function show()
    {
        $sql = "SELECT t1.*, t2.lang_name
                FROM tbl_shop_parent_category t1
                JOIN tbl_lang t2 ON t1.lang_id = t2.lang_id
                ORDER BY t1.sort_order ASC, t1.parent_category_id ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function add($data)
    {
        $this->db->table('tbl_shop_parent_category')->insert($data);
        return $this->db->insertID();
    }

    function update($id, $data)
    {
        $this->db->where('parent_category_id', $id);
        $this->db->table('tbl_shop_parent_category')->update($data);
    }

    function delete($id)
    {
        $this->db->where('parent_category_id', $id);
        $this->db->table('tbl_shop_parent_category')->delete();
    }

    function getData($id)
    {
        $sql = 'SELECT * FROM tbl_shop_parent_category WHERE parent_category_id=?';
        $query = $this->db->query($sql, [$id]);
        return $query->getRowArray();
    }

    function check($id)
    {
        return $this->getData($id);
    }

    function slug_exists($slug, $lang_id, $exclude_id = 0)
    {
        $sql = 'SELECT * FROM tbl_shop_parent_category WHERE category_slug=? AND lang_id=? AND parent_category_id!=?';
        $query = $this->db->query($sql, [$slug, $lang_id, $exclude_id]);
        return $query->getNumRows();
    }

    function check_sub_categories($id)
    {
        $sql = 'SELECT * FROM tbl_shop_sub_category WHERE parent_category_id=?';
        $query = $this->db->query($sql, [$id]);
        return $query->getNumRows();
    }

    function check_products($id)
    {
        $sql = 'SELECT * FROM tbl_shop_product_category WHERE parent_category_id=?';
        $query = $this->db->query($sql, [$id]);
        return $query->getNumRows();
    }

    function all_active($lang_id)
    {
        $sql = 'SELECT * FROM tbl_shop_parent_category WHERE lang_id=? AND status=1 ORDER BY sort_order ASC';
        $query = $this->db->query($sql, [$lang_id]);
        return $query->getResultArray();
    }
}
