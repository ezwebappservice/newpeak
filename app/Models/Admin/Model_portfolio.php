<?php
namespace App\Models\Admin;




class Model_portfolio extends \App\Models\CI3Model 
{

	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_portfolio'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function get_auto_increment_id1()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_portfolio_photo'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
	
    function show() {
        $sql = "SELECT * 
				FROM tbl_portfolio t1
				JOIN tbl_portfolio_category t2
				ON t1.category_id = t2.category_id
                JOIN tbl_lang t3
                ON t1.lang_id = t3.lang_id
                ORDER BY t1.id ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function get_all_photos_by_category_id($id)
    {
        $sql = "SELECT * 
    			FROM tbl_portfolio_photo 
    			WHERE portfolio_id=?";
        $query = $this->db->query($sql,array($id));
        return $query->getResultArray();
    }

    function get_all_photo_category()
    {
        $sql = "SELECT * 
				FROM tbl_portfolio_category
				ORDER BY category_name ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function add($data) {
        $this->db->table('tbl_portfolio')->insert($data);
        return $this->db->insert_id();
    }

    function add_photos($data) {
        $this->db->table('tbl_portfolio_photo')->insert($data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('id',$id);
        $this->db->table('tbl_portfolio')->update($data);
    }

    function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->table('tbl_portfolio')->delete();
    }

    function delete_photos($id)
    {
        $this->db->where('portfolio_id',$id);
        $this->db->table('tbl_portfolio_photo')->delete();
    }

    function getData($id)
    {
        $sql = 'SELECT * FROM tbl_portfolio WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function portfolio_check($id)
    {
        $sql = 'SELECT * FROM tbl_portfolio WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function portfolio_photo_by_id($id)
    {
        $sql = 'SELECT * FROM tbl_portfolio_photo WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }
    function delete_portfolio_photo($id)
    {
        $this->db->where('id',$id);
        $this->db->table('tbl_portfolio_photo')->delete();
    }
    
}