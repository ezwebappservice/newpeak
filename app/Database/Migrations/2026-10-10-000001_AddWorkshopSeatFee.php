<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWorkshopSeatFee extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('tbl_settings') || $this->db->fieldExists('workshop_seat_fee', 'tbl_settings')) {
            return;
        }

        $this->forge->addColumn('tbl_settings', [
            'workshop_seat_fee' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'default'    => 299,
                'null'       => false,
            ],
        ]);
    }

    public function down()
    {
        if ($this->db->tableExists('tbl_settings') && $this->db->fieldExists('workshop_seat_fee', 'tbl_settings')) {
            $this->forge->dropColumn('tbl_settings', 'workshop_seat_fee');
        }
    }
}
