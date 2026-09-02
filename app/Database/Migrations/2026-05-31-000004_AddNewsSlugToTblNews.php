<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNewsSlugToTblNews extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('tbl_news')) {
            return;
        }

        if (! $this->db->fieldExists('news_slug', 'tbl_news')) {
            $this->forge->addColumn('tbl_news', [
                'news_slug' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'news_title',
                ],
            ]);
        }

        if ($this->db->fieldExists('news_slug', 'tbl_news')) {
            $this->forge->addKey('news_slug');
        }
    }

    public function down()
    {
        if ($this->db->tableExists('tbl_news') && $this->db->fieldExists('news_slug', 'tbl_news')) {
            $this->forge->dropColumn('tbl_news', 'news_slug');
        }
    }
}
