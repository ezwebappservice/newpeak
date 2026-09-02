<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSiteInquiriesTable extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('tbl_site_inquiry')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'form_source' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'first_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'last_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'subject' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'message' => [
                'type' => 'TEXT',
            ],
            'form_data' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['New', 'Read'],
                'default'    => 'New',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['form_source', 'status', 'created_at']);
        $this->forge->createTable('tbl_site_inquiry', true);
    }

    public function down()
    {
        if ($this->db->tableExists('tbl_site_inquiry')) {
            $this->forge->dropTable('tbl_site_inquiry', true);
        }
    }
}
