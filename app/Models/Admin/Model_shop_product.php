<?php
namespace App\Models\Admin;

class Model_shop_product extends \App\Models\CI3Model
{
    function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_shop_product'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function get_auto_increment_id_image()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_shop_product_image'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function show()
    {
        $sql = "SELECT t1.*, t2.lang_name
                FROM tbl_shop_product t1
                JOIN tbl_lang t2 ON t1.lang_id = t2.lang_id
                ORDER BY t1.sort_order ASC, t1.product_id DESC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function add($data)
    {
        $this->db->table('tbl_shop_product')->insert($data);
        return $this->db->insertID();
    }

    function update($id, $data)
    {
        $this->db->where('product_id', $id);
        $this->db->table('tbl_shop_product')->update($data);
    }

    function delete($id)
    {
        $this->db->where('product_id', $id);
        $this->db->table('tbl_shop_product')->delete();
    }

    function getData($id)
    {
        $sql = 'SELECT * FROM tbl_shop_product WHERE product_id=?';
        $query = $this->db->query($sql, [$id]);
        return $query->getRowArray();
    }

    function check($id)
    {
        return $this->getData($id);
    }

    function slug_exists($slug, $lang_id, $exclude_id = 0)
    {
        $sql = 'SELECT * FROM tbl_shop_product WHERE product_slug=? AND lang_id=? AND product_id!=?';
        $query = $this->db->query($sql, [$slug, $lang_id, $exclude_id]);
        return $query->getNumRows();
    }

    function add_image($data)
    {
        $this->db->table('tbl_shop_product_image')->insert($data);
    }

    function get_images($product_id)
    {
        $sql = 'SELECT * FROM tbl_shop_product_image WHERE product_id=? ORDER BY sort_order ASC, image_id ASC';
        $query = $this->db->query($sql, [$product_id]);
        return $query->getResultArray();
    }

    function get_image($image_id)
    {
        $sql = 'SELECT * FROM tbl_shop_product_image WHERE image_id=?';
        $query = $this->db->query($sql, [$image_id]);
        return $query->getRowArray();
    }

    function delete_image($image_id)
    {
        $this->db->where('image_id', $image_id);
        $this->db->table('tbl_shop_product_image')->delete();
    }

    function delete_images_by_product($product_id)
    {
        $this->db->where('product_id', $product_id);
        $this->db->table('tbl_shop_product_image')->delete();
    }

    function save_category_mapping($product_id, $parent_category_id, $sub_category_id)
    {
        $this->db->where('product_id', $product_id);
        $this->db->table('tbl_shop_product_category')->delete();

        $this->db->table('tbl_shop_product_category')->insert([
            'product_id'           => $product_id,
            'parent_category_id'   => $parent_category_id ?: null,
            'sub_category_id'      => $sub_category_id ?: null,
        ]);
    }

    function get_category_mapping($product_id)
    {
        $sql = 'SELECT * FROM tbl_shop_product_category WHERE product_id=? LIMIT 1';
        $query = $this->db->query($sql, [$product_id]);
        return $query->getRowArray();
    }
}
