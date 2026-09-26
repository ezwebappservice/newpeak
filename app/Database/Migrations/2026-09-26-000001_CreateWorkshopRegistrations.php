<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWorkshopRegistrations extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('tbl_workshop_registration')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'public_token' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
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
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'medium' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
            ],
            'topic' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'heard_from' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
            ],
            'amount_paise' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'currency' => [
                'type'       => 'VARCHAR',
                'constraint' => 3,
                'default'    => 'INR',
            ],
            'razorpay_order_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
                'null'       => true,
            ],
            'razorpay_payment_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
                'null'       => true,
            ],
            'payment_status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'pending',
            ],
            'inquiry_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'paid_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('public_token');
        $this->forge->addKey('razorpay_order_id');
        $this->forge->addKey(['payment_status', 'created_at']);
        $this->forge->createTable('tbl_workshop_registration', true);
    }

    public function down()
    {
        if ($this->db->tableExists('tbl_workshop_registration')) {
            $this->forge->dropTable('tbl_workshop_registration', true);
        }
    }
}
