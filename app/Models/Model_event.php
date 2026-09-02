<?php
namespace App\Models;



class Model_event extends \App\Models\CI3Model 
{
    public function all_event()
    {
        $query = $this->db->query("SELECT * FROM tbl_event WHERE lang_id=? ORDER BY event_id DESC", [$_SESSION['sess_lang_id']]);
        return $query->getResultArray();
    }

    public function event_check($id)
    {
        $sql = 'SELECT * FROM tbl_event WHERE event_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getNumRows();
    }

    public function event_detail($id)
    {
        $sql = 'SELECT * FROM tbl_event WHERE event_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    public function get_total_event() {
        $sql = 'SELECT * FROM tbl_event';
        $query = $this->db->query($sql);
        return $query->getNumRows();
    }

    public function fetch_event($limit, $start) {
        $this->db->select('*');
        $this->db->from('tbl_event');
        $this->db->limit($limit, $start);
        $this->db->order_by('event_id', 'desc');
        $this->db->where('lang_id', $_SESSION['sess_lang_id']);
        $query = $this->db->get();

        if($query->getNumRows() > 0) {
            foreach ($query->getResult() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
}