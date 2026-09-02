<?php

namespace App\Models;

class Model_career extends \App\Models\CI3Model
{
    public function active_jobs(?int $langId = 5): array
    {
        $sql = 'SELECT * FROM tbl_career WHERE status = ?';
        $params = ['Active'];

        if ($langId !== null && $langId > 0) {
            $sql .= ' AND lang_id = ?';
            $params[] = $langId;
        }

        $sql .= ' ORDER BY sort_order ASC, job_title ASC';

        return $this->db->query($sql, $params)->getResultArray();
    }
}
