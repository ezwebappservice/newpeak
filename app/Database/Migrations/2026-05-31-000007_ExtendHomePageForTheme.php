<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ExtendHomePageForTheme extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('tbl_page_home')) {
            $pageHomeColumns = [
                'hero_badge'              => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'hero_title_prefix'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'hero_title_highlight'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'hero_lead'               => ['type' => 'TEXT', 'null' => true],
                'hero_btn1_text'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'hero_btn1_url'           => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
                'hero_btn2_text'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'hero_btn2_url'           => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
                'home_vision_title'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'home_vision_text'        => ['type' => 'TEXT', 'null' => true],
                'home_mission_title'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'home_mission_text'       => ['type' => 'TEXT', 'null' => true],
                'home_service_intro'      => ['type' => 'TEXT', 'null' => true],
                'home_feature_intro'      => ['type' => 'TEXT', 'null' => true],
                'home_why_choose_intro'   => ['type' => 'TEXT', 'null' => true],
                'home_cert_title'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'home_cert_subtitle'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'home_cert_intro'         => ['type' => 'TEXT', 'null' => true],
                'home_partners_tagline'   => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
                'home_feature_mini1_title'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'home_feature_mini1_text'   => ['type' => 'TEXT', 'null' => true],
                'home_feature_mini1_icon'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'home_feature_mini2_title'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'home_feature_mini2_text'   => ['type' => 'TEXT', 'null' => true],
                'home_feature_mini2_icon'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'counter_1_suffix'          => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
                'counter_2_suffix'          => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
                'counter_3_suffix'          => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
                'counter_4_suffix'          => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            ];

            foreach ($pageHomeColumns as $name => $def) {
                if (! $this->db->fieldExists($name, 'tbl_page_home')) {
                    $this->forge->addColumn('tbl_page_home', [$name => $def]);
                }
            }
        }

        if ($this->db->tableExists('tbl_page_home_lang_independent')) {
            $statusColumns = [
                'home_hero_status'           => ['type' => 'VARCHAR', 'constraint' => 10, 'default' => 'Show', 'null' => true],
                'home_certification_status'  => ['type' => 'VARCHAR', 'constraint' => 10, 'default' => 'Show', 'null' => true],
                'home_partners_status'       => ['type' => 'VARCHAR', 'constraint' => 10, 'default' => 'Show', 'null' => true],
            ];

            foreach ($statusColumns as $name => $def) {
                if (! $this->db->fieldExists($name, 'tbl_page_home_lang_independent')) {
                    $this->forge->addColumn('tbl_page_home_lang_independent', [$name => $def]);
                }
            }
        }

        if ($this->db->tableExists('tbl_service')) {
            $serviceColumns = [
                'icon'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'link_url'  => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
                'link_text' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            ];

            foreach ($serviceColumns as $name => $def) {
                if (! $this->db->fieldExists($name, 'tbl_service')) {
                    $this->forge->addColumn('tbl_service', [$name => $def]);
                }
            }
        }

        if (! $this->db->tableExists('tbl_certification')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                ],
                'description' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'icon' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
                'sort_order' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'default'    => 0,
                ],
                'lang_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable('tbl_certification', true);
        }
    }

    public function down()
    {
        if ($this->db->tableExists('tbl_certification')) {
            $this->forge->dropTable('tbl_certification', true);
        }
    }
}
