<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSlugToInvestorCategories extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('investor_categories')) {
            return;
        }

        if (! $this->db->fieldExists('category_slug', 'investor_categories')) {
            $this->forge->addColumn('investor_categories', [
                'category_slug' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'category_name',
                ],
            ]);
        }

        helper('investor');

        $rows = $this->db->table('investor_categories')->get()->getResultArray();

        foreach ($rows as $row) {
            if (! empty($row['category_slug'])) {
                continue;
            }

            $slug = investor_make_category_slug((string) $row['category_name'], (int) $row['id']);

            $this->db->table('investor_categories')
                ->where('id', (int) $row['id'])
                ->update(['category_slug' => $slug]);
        }

        if ($this->db->fieldExists('category_slug', 'investor_categories')) {
            $this->forge->modifyColumn('investor_categories', [
                'category_slug' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => false,
                ],
            ]);
            $this->db->query('ALTER TABLE investor_categories ADD UNIQUE KEY investor_categories_slug_unique (category_slug)');
        }
    }

    public function down()
    {
        if (! $this->db->tableExists('investor_categories') || ! $this->db->fieldExists('category_slug', 'investor_categories')) {
            return;
        }

        $this->forge->dropKey('investor_categories', 'investor_categories_slug_unique', true);
        $this->forge->dropColumn('investor_categories', 'category_slug');
    }
}
