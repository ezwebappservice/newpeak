<?php
namespace App\Models\Admin;



class Model_event extends \App\Models\CI3Model 
{

	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_event'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function show() {
        $sql = "SELECT * 
                FROM tbl_event t1
                JOIN tbl_lang t2
                ON t1.lang_id = t2.lang_id
                ORDER BY t1.event_id DESC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }


    function add($data) {
        $this->db->table('tbl_event')->insert($data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('event_id',$id);
        $this->db->table('tbl_event')->update($data);
    }

    function delete($id)
    {
        $this->db->where('event_id',$id);
        $this->db->table('tbl_event')->delete();
    }

    function getData($id)
    {
        $sql = 'SELECT * FROM tbl_event WHERE event_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function event_check($id)
    {
        $sql = 'SELECT * FROM tbl_event WHERE event_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }
   
}