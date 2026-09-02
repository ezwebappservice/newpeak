<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToPageDynamic extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('status', 'tbl_page_dynamic')) {
            $this->forge->addColumn('tbl_page_dynamic', [
                'status' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'default'    => 'Active',
                    'after'      => 'lang_id',
                ],
            ]);
        }

        $this->db->table('tbl_page_dynamic')->update(['status' => 'Active']);
    }

    public function down()
    {
        if ($this->db->fieldExists('status', 'tbl_page_dynamic')) {
            $this->forge->dropColumn('tbl_page_dynamic', 'status');
        }
    }
}
