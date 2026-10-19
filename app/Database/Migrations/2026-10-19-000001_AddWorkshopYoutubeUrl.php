<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWorkshopYoutubeUrl extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('tbl_settings') || $this->db->fieldExists('workshop_youtube_url', 'tbl_settings')) {
            return;
        }

        $this->forge->addColumn('tbl_settings', [
            'workshop_youtube_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        if ($this->db->tableExists('tbl_settings') && $this->db->fieldExists('workshop_youtube_url', 'tbl_settings')) {
            $this->forge->dropColumn('tbl_settings', 'workshop_youtube_url');
        }
    }
}
