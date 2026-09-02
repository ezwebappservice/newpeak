<?php
namespace App\Models\Admin;



class Model_feature extends \App\Models\CI3Model 
{

    function show() {
        $sql = "SELECT * 
                FROM tbl_feature t1
                JOIN tbl_lang t2
                ON t1.lang_id = t2.lang_id";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function add($data) {
        $this->db->table('tbl_feature')->insert($data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('id',$id);
        $this->db->table('tbl_feature')->update($data);
    }

    function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->table('tbl_feature')->delete();
    }

    function getData($id)
    {
        $sql = 'SELECT * FROM tbl_feature WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function feature_check($id)
    {
        $sql = 'SELECT * FROM tbl_feature WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }
    
}