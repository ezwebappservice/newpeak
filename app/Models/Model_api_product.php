<?php

namespace App\Models;

class Model_api_product extends \App\Models\CI3Model
{
    public function active_list(string $productType, ?int $langId = null): array
    {
        $langId = $langId ?? (int) ($_SESSION['sess_lang_id'] ?? 5);

        $sql = "SELECT id, product_name, therapeutic_category, us_dmf, eu_status, patent_status, remarks, sort_order
                FROM tbl_api_product
                WHERE product_type = ? AND status = 'Active' AND lang_id = ?
                ORDER BY sort_order ASC, product_name ASC";

        return $this->db->query($sql, [$productType, $langId])->getResultArray();
    }
}
