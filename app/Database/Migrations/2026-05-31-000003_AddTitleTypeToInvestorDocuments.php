<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTitleTypeToInvestorDocuments extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('investor_documents')) {
            return;
        }

        if ($this->db->fieldExists('title_type', 'investor_documents')) {
            return;
        }

        $this->forge->addColumn('investor_documents', [
            'title_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'file_title',
            ],
        ]);
    }

    public function down()
    {
        if ($this->db->tableExists('investor_documents') && $this->db->fieldExists('title_type', 'investor_documents')) {
            $this->forge->dropColumn('investor_documents', 'title_type');
        }
    }
}
