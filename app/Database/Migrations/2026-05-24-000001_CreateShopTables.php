<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateShopTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'parent_category_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'category_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'category_slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'category_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
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
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'lang_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1,
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
        $this->forge->addKey('parent_category_id', true);
        $this->forge->addUniqueKey(['category_slug', 'lang_id']);
        $this->forge->createTable('tbl_shop_parent_category', true);

        $this->forge->addField([
            'sub_category_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'parent_category_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'category_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'category_slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'category_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
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
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'lang_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1,
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
        $this->forge->addKey('sub_category_id', true);
        $this->forge->addUniqueKey(['category_slug', 'lang_id']);
        $this->forge->addForeignKey('parent_category_id', 'tbl_shop_parent_category', 'parent_category_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tbl_shop_sub_category', true);

        $this->forge->addField([
            'product_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'product_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'product_slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'short_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'full_description' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'featured_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'stock_quantity' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
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
            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'lang_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
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
        $this->forge->addKey('product_id', true);
        $this->forge->addUniqueKey(['product_slug', 'lang_id']);
        $this->forge->createTable('tbl_shop_product', true);

        $this->forge->addField([
            'image_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'product_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'image_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
        ]);
        $this->forge->addKey('image_id', true);
        $this->forge->addForeignKey('product_id', 'tbl_shop_product', 'product_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tbl_shop_product_image', true);

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'product_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'parent_category_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'sub_category_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('product_id', 'tbl_shop_product', 'product_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('parent_category_id', 'tbl_shop_parent_category', 'parent_category_id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('sub_category_id', 'tbl_shop_sub_category', 'sub_category_id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('tbl_shop_product_category', true);
    }

    public function down()
    {
        $this->forge->dropTable('tbl_shop_product_category', true);
        $this->forge->dropTable('tbl_shop_product_image', true);
        $this->forge->dropTable('tbl_shop_product', true);
        $this->forge->dropTable('tbl_shop_sub_category', true);
        $this->forge->dropTable('tbl_shop_parent_category', true);
    }
}
