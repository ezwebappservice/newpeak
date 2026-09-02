<?php
namespace App\Models;



class Model_category extends \App\Models\CI3Model 
{
    public function all_news_by_category_id($id)
    {
        $query = $this->db->query("SELECT * FROM tbl_news WHERE category_id=? ORDER BY news_id DESC", array($id));
        return $query->getResultArray();
    }

    public function category_by_id($id)
    {
        $query = $this->db->query("SELECT * FROM tbl_category WHERE category_id=?", array($id));
        return $query->getRowArray();
    }

    public function category_check($id) {
        $sql = 'SELECT * FROM tbl_category WHERE category_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getNumRows();
    }
}