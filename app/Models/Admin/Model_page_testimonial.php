<?php
namespace App\Models\Admin;



class Model_page_testimonial extends \App\Models\CI3Model 
{
    function show()
    {
        $sql = "SELECT * 
                FROM tbl_page_testimonial t1
                JOIN tbl_lang t2
                ON t1.lang_id = t2.lang_id
                ORDER BY id ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function update($id,$data) 
    {
        $this->db->where('id',$id);
        $this->db->table('tbl_page_testimonial')->update($data);
    }

    function get_page_testimonial($id)
    {
        $query = $this->db->query("SELECT * 
                FROM tbl_page_testimonial t1 
                JOIN tbl_lang t2 
                ON t1.lang_id = t2.lang_id 
                WHERE t1.id=?",
                [$id]
            );
        return $query->getRowArray();
    }

    function page_testimonial_check($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_page_testimonial');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->getRowArray();
    }
}