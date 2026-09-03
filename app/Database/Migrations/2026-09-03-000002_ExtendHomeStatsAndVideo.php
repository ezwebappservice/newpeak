<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ExtendHomeStatsAndVideo extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('tbl_page_home')) {
            return;
        }

        foreach (['counter_1_value', 'counter_2_value', 'counter_3_value', 'counter_4_value'] as $column) {
            $this->forge->modifyColumn('tbl_page_home', [
                $column => [
                    'name'       => $column,
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => false,
                ],
            ]);
        }

        $newColumns = [
            'counter_5_title'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'counter_5_value'  => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'counter_5_suffix' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'counter_5_icon'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
        ];

        foreach ($newColumns as $name => $def) {
            if (! $this->db->fieldExists($name, 'tbl_page_home')) {
                $this->forge->addColumn('tbl_page_home', [$name => $def]);
            }
        }

        $this->db->table('tbl_page_home')->update([
            'home_welcome_title'    => 'Discover More',
            'home_welcome_subtitle' => 'A closer look at what we do',
            'home_welcome_text'     => '<p>Discover how Peak Potential Academy helps students, parents, schools, and organisations move forward with greater clarity, confidence, and purpose.</p>',
            'counter_1_title'       => 'Students Trusted',
            'counter_1_value'       => '5000',
            'counter_1_suffix'      => '+',
            'counter_2_title'       => 'Lives Impacted',
            'counter_2_value'       => '5,000',
            'counter_2_suffix'      => '+',
            'counter_3_title'       => 'Global Education Leader',
            'counter_3_value'       => 'Top 100',
            'counter_3_suffix'      => '',
            'counter_4_title'       => 'Years Leadership',
            'counter_4_value'       => '15',
            'counter_4_suffix'      => '+',
            'counter_5_title'       => '35th World Education Summit, Dubai',
            'counter_5_value'       => 'Awardee In',
            'counter_5_suffix'      => '',
        ]);

        if ($this->db->tableExists('tbl_page_home_lang_independent')) {
            $this->db->table('tbl_page_home_lang_independent')->where('id', 1)->update([
                'home_welcome_video'  => 'https://www.youtube.com/watch?v=Ve2IHBwbzus',
                'home_welcome_status' => 'Show',
                'counter_status'      => 'Show',
            ]);
        }
    }

    public function down()
    {
        if (! $this->db->tableExists('tbl_page_home')) {
            return;
        }

        foreach (['counter_5_title', 'counter_5_value', 'counter_5_suffix', 'counter_5_icon'] as $column) {
            if ($this->db->fieldExists($column, 'tbl_page_home')) {
                $this->forge->dropColumn('tbl_page_home', $column);
            }
        }
    }
}
