<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTeamIntroFieldsToPageTeam extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('tbl_page_team')) {
            return;
        }

        if (! $this->db->fieldExists('team_subtitle', 'tbl_page_team')) {
            $this->forge->addColumn('tbl_page_team', [
                'team_subtitle' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'team_heading',
                ],
                'team_intro' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'after' => 'team_subtitle',
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->tableExists('tbl_page_team')) {
            if ($this->db->fieldExists('team_subtitle', 'tbl_page_team')) {
                $this->forge->dropColumn('tbl_page_team', 'team_subtitle');
            }
            if ($this->db->fieldExists('team_intro', 'tbl_page_team')) {
                $this->forge->dropColumn('tbl_page_team', 'team_intro');
            }
        }
    }
}
