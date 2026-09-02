<?php
namespace App\Models\Admin;

class Model_shop_sub_category extends \App\Models\CI3Model
{
    function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_shop_sub_category'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function show()
    {
        $sql = "SELECT t1.*, t2.lang_name, t3.category_name AS parent_name
                FROM tbl_shop_sub_category t1
                JOIN tbl_lang t2 ON t1.lang_id = t2.lang_id
                JOIN tbl_shop_parent_category t3 ON t1.parent_category_id = t3.parent_category_id
                ORDER BY t1.sort_order ASC, t1.sub_category_id ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function add($data)
    {
        $this->db->table('tbl_shop_sub_category')->insert($data);
        return $this->db->insertID();
    }

    function update($id, $data)
    {
        $this->db->where('sub_category_id', $id);
        $this->db->table('tbl_shop_sub_category')->update($data);
    }

    function delete($id)
    {
        $this->db->where('sub_category_id', $id);
        $this->db->table('tbl_shop_sub_category')->delete();
    }

    function getData($id)
    {
        $sql = 'SELECT * FROM tbl_shop_sub_category WHERE sub_category_id=?';
        $query = $this->db->query($sql, [$id]);
        return $query->getRowArray();
    }

    function check($id)
    {
        return $this->getData($id);
    }

    function slug_exists($slug, $lang_id, $exclude_id = 0)
    {
        $sql = 'SELECT * FROM tbl_shop_sub_category WHERE category_slug=? AND lang_id=? AND sub_category_id!=?';
        $query = $this->db->query($sql, [$slug, $lang_id, $exclude_id]);
        return $query->getNumRows();
    }

    function check_products($id)
    {
        $sql = 'SELECT * FROM tbl_shop_product_category WHERE sub_category_id=?';
        $query = $this->db->query($sql, [$id]);
        return $query->getNumRows();
    }

    function by_parent($parent_id, $lang_id)
    {
        $sql = 'SELECT * FROM tbl_shop_sub_category WHERE parent_category_id=? AND lang_id=? ORDER BY sort_order ASC';
        $query = $this->db->query($sql, [$parent_id, $lang_id]);
        return $query->getResultArray();
    }
}
