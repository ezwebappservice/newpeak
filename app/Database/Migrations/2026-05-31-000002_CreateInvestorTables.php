<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInvestorTables extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('investor_categories')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'category_name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                ],
                'status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['Active', 'Inactive'],
                    'default'    => 'Active',
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
            $this->forge->addKey('status');
            $this->forge->addKey('category_name');
            $this->forge->createTable('investor_categories', true);
        }

        if (! $this->db->tableExists('investor_documents')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'category_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],
                'year' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                ],
                'file_title' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                ],
                'title_type' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
                'document_type' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => true,
                ],
                'file_name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                ],
                'original_file_name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                ],
                'file_size' => [
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
            $this->forge->addKey('category_id');
            $this->forge->addKey('year');
            $this->forge->addKey('document_type');
            $this->forge->addKey('status');
            $this->forge->addKey('file_title');
            $this->forge->addForeignKey('category_id', 'investor_categories', 'id', 'CASCADE', 'RESTRICT');
            $this->forge->createTable('investor_documents', true);
        }
    }

    public function down()
    {
        if ($this->db->tableExists('investor_documents')) {
            $this->forge->dropTable('investor_documents', true);
        }

        if ($this->db->tableExists('investor_categories')) {
            $this->forge->dropTable('investor_categories', true);
        }
    }
}
