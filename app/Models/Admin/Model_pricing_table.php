<?php
namespace App\Models\Admin;



class Model_pricing_table extends \App\Models\CI3Model 
{

	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_pricing_table'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
	
    function show() {
        $sql = "SELECT * 
                FROM tbl_pricing_table t1
                JOIN tbl_lang t2
                ON t1.lang_id = t2.lang_id";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function add($data) {
        $this->db->table('tbl_pricing_table')->insert($data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('id',$id);
        $this->db->table('tbl_pricing_table')->update($data);
    }

    function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->table('tbl_pricing_table')->delete();
    }

    function getData($id)
    {
        $sql = 'SELECT * FROM tbl_pricing_table WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function pricing_table_check($id)
    {
        $sql = 'SELECT * FROM tbl_pricing_table WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }
    
}