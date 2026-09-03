<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ExtendHomeHeroContent extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('tbl_page_home')) {
            return;
        }

        $columns = [
            'hero_title_suffix'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hero_feature_1_title' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hero_feature_2_title' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hero_feature_3_title' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hero_card_name'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hero_card_role'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hero_card_org'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hero_card_badge'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hero_tab_text'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ];

        foreach ($columns as $name => $def) {
            if (! $this->db->fieldExists($name, 'tbl_page_home')) {
                $this->forge->addColumn('tbl_page_home', [$name => $def]);
            }
        }

        $this->db->table('tbl_page_home')->update([
            'hero_badge'            => 'THE HUMAN POTENTIAL INSTITUTE',
            'hero_title_prefix'     => 'Break the',
            'hero_title_highlight'  => 'Invisible Loops',
            'hero_title_suffix'     => 'Holding You Back.',
            'hero_lead'             => 'We work with both students and parents to create lasting change. Students build emotional, communication and financial intelligence beyond academics. Parents gain practical tools to manage screens, behaviour and everyday conflict. Together, they build calmer relationships and confident, life-ready children.',
            'hero_btn1_text'        => 'Book a Discovery Call',
            'hero_btn1_url'         => 'customer-enquiry-form',
            'hero_btn2_text'        => 'Request a Proposal',
            'hero_btn2_url'         => 'contact-us',
            'hero_feature_1_title'  => "Screen\nAddiction",
            'hero_feature_2_title'  => "Emotional\nOverwhelm",
            'hero_feature_3_title'  => "Limiting\nPatterns",
            'hero_card_name'        => 'Sapna KS',
            'hero_card_role'        => 'Emotional Strength Educator',
            'hero_card_org'         => 'Founder, Peak Potential Academy',
            'hero_card_badge'       => "Top 100 Global\nEducation Leader",
            'hero_tab_text'         => 'Book ₹599 Session',
        ]);
    }

    public function down()
    {
        if (! $this->db->tableExists('tbl_page_home')) {
            return;
        }

        foreach ([
            'hero_title_suffix',
            'hero_feature_1_title',
            'hero_feature_2_title',
            'hero_feature_3_title',
            'hero_card_name',
            'hero_card_role',
            'hero_card_org',
            'hero_card_badge',
            'hero_tab_text',
        ] as $column) {
            if ($this->db->fieldExists($column, 'tbl_page_home')) {
                $this->forge->dropColumn('tbl_page_home', $column);
            }
        }
    }
}
