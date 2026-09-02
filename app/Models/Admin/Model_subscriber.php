<?php
namespace App\Models\Admin;



class Model_subscriber extends \App\Models\CI3Model 
{
    function show_active_subscriber() {
        $sql = "SELECT * FROM tbl_subscriber WHERE subs_active=1 ORDER BY subs_date_time DESC, subs_id DESC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function show_all_subscribers() {
        $sql = "SELECT * FROM tbl_subscriber ORDER BY subs_date_time DESC, subs_id DESC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
   
    function delete_pending_subscriber()
    {
        $this->db->where('subs_active',0);
        $this->db->table('tbl_subscriber')->delete();
    }

    function delete($id)
    {
        $this->db->where('subs_id',$id);
        $this->db->table('tbl_subscriber')->delete();
    }
    
    function subscriber_check($id)
    {
        $sql = 'SELECT * FROM tbl_subscriber WHERE subs_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }    
}