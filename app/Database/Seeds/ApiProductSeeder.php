<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ApiProductSeeder extends Seeder
{
    public function run()
    {
        if (! $this->db->tableExists('tbl_api_product')) {
            echo "tbl_api_product not found. Run migrations first.\n";

            return;
        }

        $existing = $this->db->table('tbl_api_product')->countAllResults();

        if ($existing > 0) {
            echo "API products already seeded ({$existing} rows).\n";

            return;
        }

        $now = date('Y-m-d H:i:s');
        $langId = 5;

        $oncology = [
            ['product_name' => 'Capecitabine', 'therapeutic_category' => 'Antineoplastic', 'us_dmf' => 'Available', 'eu_status' => 'CEP', 'patent_status' => 'Off Patent', 'remarks' => null, 'sort_order' => 1],
            ['product_name' => 'Gemcitabine HCl', 'therapeutic_category' => 'Antineoplastic', 'us_dmf' => 'Available', 'eu_status' => 'CEP', 'patent_status' => 'Off Patent', 'remarks' => null, 'sort_order' => 2],
            ['product_name' => 'Imatinib Mesylate', 'therapeutic_category' => 'Antineoplastic', 'us_dmf' => 'Available', 'eu_status' => 'CEP', 'patent_status' => 'Off Patent', 'remarks' => null, 'sort_order' => 3],
        ];

        $nonOncology = [
            ['product_name' => 'Atorvastatin Calcium', 'therapeutic_category' => 'Cardiovascular', 'us_dmf' => 'Available', 'eu_status' => 'CEP', 'patent_status' => 'Off Patent', 'remarks' => null, 'sort_order' => 1],
            ['product_name' => 'Metformin HCl', 'therapeutic_category' => 'Anti-diabetic', 'us_dmf' => 'Available', 'eu_status' => 'CEP', 'patent_status' => 'Off Patent', 'remarks' => null, 'sort_order' => 2],
            ['product_name' => 'Pantoprazole Sodium', 'therapeutic_category' => 'Gastrointestinal', 'us_dmf' => 'Available', 'eu_status' => 'CEP', 'patent_status' => 'Off Patent', 'remarks' => null, 'sort_order' => 3],
        ];

        foreach ($oncology as $row) {
            $this->db->table('tbl_api_product')->insert(array_merge($row, [
                'product_type' => 'oncology',
                'status'       => 'Active',
                'lang_id'      => $langId,
                'created_at'   => $now,
                'updated_at'   => $now,
            ]));
        }

        foreach ($nonOncology as $row) {
            $this->db->table('tbl_api_product')->insert(array_merge($row, [
                'product_type' => 'non_oncology',
                'status'       => 'Active',
                'lang_id'      => $langId,
                'created_at'   => $now,
                'updated_at'   => $now,
            ]));
        }

        echo 'Seeded ' . (count($oncology) + count($nonOncology)) . " API products.\n";
    }
}
