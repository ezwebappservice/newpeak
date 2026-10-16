<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWorkshopSchedule extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('tbl_settings')) {
            return;
        }

        $columns = [];

        if (! $this->db->fieldExists('workshop_event_date', 'tbl_settings')) {
            $columns['workshop_event_date'] = [
                'type'       => 'VARCHAR',
                'constraint' => 80,
                'null'       => true,
                'default'    => '18 Oct 2026',
            ];
        }

        if (! $this->db->fieldExists('workshop_event_time', 'tbl_settings')) {
            $columns['workshop_event_time'] = [
                'type'       => 'VARCHAR',
                'constraint' => 80,
                'null'       => true,
                'default'    => '07 AM – 08 AM',
            ];
        }

        if (! $this->db->fieldExists('workshop_event_format', 'tbl_settings')) {
            $columns['workshop_event_format'] = [
                'type'       => 'VARCHAR',
                'constraint' => 120,
                'null'       => true,
                'default'    => 'Live on Zoom',
            ];
        }

        if (! $this->db->fieldExists('workshop_zoom_link', 'tbl_settings')) {
            $columns['workshop_zoom_link'] = [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ];
        }

        if ($columns !== []) {
            $this->forge->addColumn('tbl_settings', $columns);
        }
    }

    public function down()
    {
        if (! $this->db->tableExists('tbl_settings')) {
            return;
        }

        foreach (['workshop_zoom_link', 'workshop_event_format', 'workshop_event_time', 'workshop_event_date'] as $column) {
            if ($this->db->fieldExists($column, 'tbl_settings')) {
                $this->forge->dropColumn('tbl_settings', $column);
            }
        }
    }
}
