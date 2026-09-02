<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddParentIdToInvestorCategories extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('investor_categories')) {
            return;
        }

        if ($this->db->fieldExists('parent_id', 'investor_categories')) {
            return;
        }

        $this->forge->addColumn('investor_categories', [
            'parent_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'category_name',
            ],
        ]);

        $this->forge->addKey('parent_id');
        $this->forge->addForeignKey(
            'parent_id',
            'investor_categories',
            'id',
            'RESTRICT',
            'CASCADE',
            'investor_categories_parent_fk'
        );
    }

    public function down()
    {
        if (! $this->db->tableExists('investor_categories') || ! $this->db->fieldExists('parent_id', 'investor_categories')) {
            return;
        }

        $this->forge->dropForeignKey('investor_categories', 'investor_categories_parent_fk');
        $this->forge->dropColumn('investor_categories', 'parent_id');
    }
}
