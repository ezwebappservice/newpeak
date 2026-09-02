<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ExtendContactPageAndLocations extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('tbl_page_contact')) {
            if (! $this->db->fieldExists('contact_subtitle', 'tbl_page_contact')) {
                $this->forge->addColumn('tbl_page_contact', [
                    'contact_subtitle' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 255,
                        'null'       => true,
                        'after'      => 'contact_heading',
                    ],
                    'contact_intro' => [
                        'type' => 'TEXT',
                        'null' => true,
                        'after' => 'contact_subtitle',
                    ],
                    'contact_hours' => [
                        'type' => 'TEXT',
                        'null' => true,
                        'after' => 'contact_intro',
                    ],
                    'contact_website' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 255,
                        'null'       => true,
                        'after' => 'contact_hours',
                    ],
                ]);
            }
        }

        if (! $this->db->tableExists('tbl_contact_locations')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'title' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                ],
                'address' => [
                    'type' => 'TEXT',
                ],
                'sort_order' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'default'    => 0,
                ],
                'status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['Active', 'Inactive'],
                    'default'    => 'Active',
                ],
                'lang_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addKey('lang_id');
            $this->forge->addKey('status');
            $this->forge->createTable('tbl_contact_locations', true);
        }
    }

    public function down()
    {
        if ($this->db->tableExists('tbl_contact_locations')) {
            $this->forge->dropTable('tbl_contact_locations', true);
        }

        if ($this->db->tableExists('tbl_page_contact')) {
            foreach (['contact_subtitle', 'contact_intro', 'contact_hours', 'contact_website'] as $col) {
                if ($this->db->fieldExists($col, 'tbl_page_contact')) {
                    $this->forge->dropColumn('tbl_page_contact', $col);
                }
            }
        }
    }
}
