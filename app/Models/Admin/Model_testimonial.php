<?php
namespace App\Models\Admin;



class Model_testimonial extends \App\Models\CI3Model 
{

	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_testimonial'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
	
    function show() {
        $sql = "SELECT * 
                FROM tbl_testimonial t1
                JOIN tbl_lang t2
                ON t1.lang_id = t2.lang_id
                ORDER BY t1.id ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function add($data) {
        $this->db->table('tbl_testimonial')->insert($data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('id',$id);
        $this->db->table('tbl_testimonial')->update($data);
    }

    function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->table('tbl_testimonial')->delete();
    }

    function get_testimonial($id)
    {
        $sql = 'SELECT * FROM tbl_testimonial WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function testimonial_check($id)
    {
        $sql = 'SELECT * FROM tbl_testimonial WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }
    
}