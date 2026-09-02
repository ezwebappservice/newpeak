<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InvestorCategoriesSeeder extends Seeder
{
    public function run()
    {
        if (! $this->db->tableExists('investor_categories')) {
            return;
        }

        $existing = $this->db->table('investor_categories')->countAllResults();

        if ($existing > 0) {
            return;
        }

        $now = date('Y-m-d H:i:s');
        $categories = [
            'Annual Reports',
            'Financial Results',
            'Shareholding Pattern',
            'Corporate Governance',
            'Notices & Announcements',
            'Policies',
            'Investor Presentations',
        ];

        $rows = [];
        $sortOrder = 0;

        foreach ($categories as $name) {
            $sortOrder += 10;
            $rows[] = [
                'category_name' => $name,
                'category_slug' => url_title($name, '-', true),
                'parent_id'     => null,
                'sort_order'    => $sortOrder,
                'status'        => 'Active',
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        $this->db->table('investor_categories')->insertBatch($rows);
    }
}
