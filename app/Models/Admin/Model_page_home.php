<?php
namespace App\Models\Admin;



class Model_page_home extends \App\Models\CI3Model 
{
    function show()
    {
        $sql = "SELECT * 
                FROM tbl_page_home t1
                JOIN tbl_lang t2
                ON t1.lang_id = t2.lang_id
                ORDER BY id ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function show_lang_independent()
    {
        $sql = "SELECT * FROM tbl_page_home_lang_independent WHERE id=?";
        $query = $this->db->query($sql,[1]);
        return $query->getRowArray();
    }

    function update($id,$data) 
    {
        $this->db->where('id',$id);
        $this->db->table('tbl_page_home')->update($data);
    }

    function get_page_home($id)
    {
        $query = $this->db->query("SELECT * 
                FROM tbl_page_home t1 
                JOIN tbl_lang t2 
                ON t1.lang_id = t2.lang_id 
                WHERE t1.id=?",
                [$id]
            );
        return $query->getRowArray();
    }

    function page_home_check($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_page_home');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->getRowArray();
    }

    public function update_home($data)
    {
        $this->db->where('id',1);
        $this->db->table('tbl_page_home_lang_independent')->update($data);
    }
}