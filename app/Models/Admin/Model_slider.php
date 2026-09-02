<?php
namespace App\Models\Admin;



class Model_slider extends \App\Models\CI3Model 
{
	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_slider'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
	
    function show() {
        $sql = "SELECT * 
                FROM tbl_slider t1
                JOIN tbl_lang t2
                ON t1.lang_id = t2.lang_id";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function add($data) {
        $this->db->table('tbl_slider')->insert($data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('id',$id);
        $this->db->table('tbl_slider')->update($data);
    }

    function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->table('tbl_slider')->delete();
    }

    function getData($id)
    {
        $sql = 'SELECT * FROM tbl_slider WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function slider_check($id)
    {
        $sql = 'SELECT * FROM tbl_slider WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }
    
}