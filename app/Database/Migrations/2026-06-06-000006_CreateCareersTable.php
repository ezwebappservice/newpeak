<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCareersTable extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('tbl_career')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'job_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'department' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'location' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'job_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'experience' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'short_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'job_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'requirements' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'apply_email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
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
                'default'    => 5,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['status', 'sort_order']);
        $this->forge->addKey('lang_id');
        $this->forge->createTable('tbl_career', true);
    }

    public function down()
    {
        if ($this->db->tableExists('tbl_career')) {
            $this->forge->dropTable('tbl_career', true);
        }
    }
}
