<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNavMenuTable extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('tbl_nav_menu')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'parent_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'default'    => 0,
            ],
            'lang_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'label' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'link_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'page',
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'custom_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'menu_status' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'default'    => 'Show',
            ],
            'meta_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'meta_keyword' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'meta_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['lang_id', 'parent_id', 'sort_order']);
        $this->forge->createTable('tbl_nav_menu', true);
    }

    public function down()
    {
        if ($this->db->tableExists('tbl_nav_menu')) {
            $this->forge->dropTable('tbl_nav_menu', true);
        }
    }
}
