<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ExtendSiteInquirySources extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('tbl_site_inquiry')) {
            return;
        }

        $this->db->query('ALTER TABLE tbl_site_inquiry MODIFY form_source VARCHAR(50) NOT NULL');

        if (! $this->db->fieldExists('form_data', 'tbl_site_inquiry')) {
            $this->forge->addColumn('tbl_site_inquiry', [
                'form_data' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'after' => 'message',
                ],
            ]);
        }
    }

    public function down()
    {
        if (! $this->db->tableExists('tbl_site_inquiry')) {
            return;
        }

        if ($this->db->fieldExists('form_data', 'tbl_site_inquiry')) {
            $this->forge->dropColumn('tbl_site_inquiry', 'form_data');
        }
    }
}
