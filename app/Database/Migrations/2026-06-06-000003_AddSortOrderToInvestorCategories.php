<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSortOrderToInvestorCategories extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('investor_categories')) {
            return;
        }

        if (! $this->db->fieldExists('sort_order', 'investor_categories')) {
            $this->forge->addColumn('investor_categories', [
                'sort_order' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'default'    => 0,
                    'after'      => 'parent_id',
                ],
            ]);
        }

        $rows = $this->db->table('investor_categories')
            ->orderBy('parent_id', 'ASC')
            ->orderBy('category_name', 'ASC')
            ->get()
            ->getResultArray();

        $parentOrder = 0;
        $childCounters = [];

        foreach ($rows as $row) {
            $parentId = (int) ($row['parent_id'] ?? 0);

            if ($parentId <= 0) {
                $parentOrder++;
                $sortOrder = $parentOrder * 10;
            } else {
                $childCounters[$parentId] = ($childCounters[$parentId] ?? 0) + 1;
                $sortOrder = $childCounters[$parentId];
            }

            $this->db->table('investor_categories')
                ->where('id', (int) $row['id'])
                ->update(['sort_order' => $sortOrder]);
        }
    }

    public function down()
    {
        if ($this->db->tableExists('investor_categories') && $this->db->fieldExists('sort_order', 'investor_categories')) {
            $this->forge->dropColumn('investor_categories', 'sort_order');
        }
    }
}
