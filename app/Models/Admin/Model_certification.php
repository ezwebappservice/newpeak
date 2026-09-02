<?php
namespace App\Models\Admin;

class Model_certification extends \App\Models\CI3Model
{
    public function show()
    {
        $sql = 'SELECT * FROM tbl_certification t1 JOIN tbl_lang t2 ON t1.lang_id = t2.lang_id ORDER BY t1.sort_order ASC, t1.id ASC';
        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_certification')->insert($data);

        return $this->db->insertID();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->table('tbl_certification')->update($data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->table('tbl_certification')->delete();
    }

    public function getData($id)
    {
        $query = $this->db->query('SELECT * FROM tbl_certification WHERE id=?', [$id]);

        return $query->getRowArray();
    }

    public function certification_check($id)
    {
        $query = $this->db->query('SELECT * FROM tbl_certification WHERE id=?', [$id]);

        return $query->getRowArray();
    }
}
