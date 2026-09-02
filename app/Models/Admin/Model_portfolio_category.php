<?php
namespace App\Models\Admin;



class Model_portfolio_category extends \App\Models\CI3Model 
{
	
    function show() {
        $sql = "SELECT * 
                FROM tbl_portfolio_category t1
                JOIN tbl_lang t2
                ON t1.lang_id = t2.lang_id
                ORDER BY t1.category_id ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function show_portfolio_by_id($id) {
        $sql = "SELECT * FROM tbl_portfolio WHERE id=?";
        $query = $this->db->query($sql,$id);
        return $query->getResultArray();
    }

    function show_portfolio_photo_by_portfolio_id($id) {
        $sql = "SELECT * FROM tbl_portfolio_photo WHERE portfolio_id=?";
        $query = $this->db->query($sql,$id);
        return $query->getResultArray();
    }

    function add($data) {
        $this->db->table('tbl_portfolio_category')->insert($data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('category_id',$id);
        $this->db->table('tbl_portfolio_category')->update($data);
    }

    function delete($id)
    {
        $this->db->where('category_id',$id);
        $this->db->table('tbl_portfolio_category')->delete();
    }

    function delete1($id)
    {
        $this->db->where('id',$id);
        $this->db->table('tbl_portfolio')->delete();
    }

    function delete2($id)
    {
        $this->db->where('portfolio_id',$id);
        $this->db->table('tbl_portfolio_photo')->delete();
    }

    function getData($id)
    {
        $sql = 'SELECT * FROM tbl_portfolio_category WHERE category_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function getData1($id)
    {
        $sql = 'SELECT * FROM tbl_portfolio WHERE category_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getResultArray();
    }

    function portfolio_category_check($id)
    {
        $sql = 'SELECT * FROM tbl_portfolio_category WHERE category_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function duplicate_check($var1,$var2) {
        $sql = 'SELECT * FROM tbl_portfolio_category WHERE category_name=? and category_name!=?';
        $query = $this->db->query($sql,array($var1,$var2));
        return $query->getNumRows();
    }
    
}