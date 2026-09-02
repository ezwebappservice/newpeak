<?php
namespace App\Models\Admin;

class Model_page_dynamic extends \App\Models\CI3Model
{
    function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_page_dynamic'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    /**
     * @param string $filter all|active|inactive
     */
    function show($filter = 'all')
    {
        $sql = "SELECT t1.*, t2.lang_name
                FROM tbl_page_dynamic t1
                JOIN tbl_lang t2 ON t1.lang_id = t2.lang_id";

        if ($filter === 'active') {
            $sql .= " WHERE t1.status = 'Active'";
        } elseif ($filter === 'inactive') {
            $sql .= " WHERE t1.status = 'Inactive'";
        }

        $sql .= " ORDER BY t1.status ASC, t1.name ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function add($data)
    {
        $this->db->table('tbl_page_dynamic')->insert($data);
        return $this->db->insert_id();
    }

    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->table('tbl_page_dynamic')->update($data);
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->table('tbl_page_dynamic')->delete();
    }

    function getData($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_page_dynamic');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->getRowArray();
    }

    function page_dynamic_check($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_page_dynamic');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->getRowArray();
    }

    function slug_duplication_check($slug)
    {
        $sql = 'SELECT * FROM tbl_page_dynamic WHERE slug=?';
        $query = $this->db->query($sql, [$slug]);
        return $query->getNumRows();
    }

    function slug_duplication_check_edit($slug, $slug2)
    {
        $sql = 'SELECT * FROM tbl_page_dynamic WHERE slug=? AND slug!=?';
        $query = $this->db->query($sql, [$slug, $slug2]);
        return $query->getNumRows();
    }
}
