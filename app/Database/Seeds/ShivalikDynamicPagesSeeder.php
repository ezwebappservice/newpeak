<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Config\ShivalikPages;

class ShivalikDynamicPagesSeeder extends Seeder
{
    public function run()
    {
        $config = config(ShivalikPages::class);

        $langRow = $this->db->table('tbl_lang')
            ->where('lang_default', 'Yes')
            ->get()
            ->getRowArray();
        $langId = (int) ($langRow['lang_id'] ?? 5);

        $defaultBanner = 'banner_about.jpg';
        if (! is_file(FCPATH . 'uploads/' . $defaultBanner)) {
            $defaultBanner = 'page-dynamic-banner-1.jpg';
        }

        $this->db->table('tbl_page_dynamic')->where('lang_id', $langId)->delete();

        $sort = 0;
        foreach ($config->slugs as $slug) {
            $def = $config->definitions[$slug] ?? [
                'name'             => ucwords(str_replace('-', ' ', $slug)),
                'meta_title'       => ucwords(str_replace('-', ' ', $slug)) . ' | Shivalik Rasayan Limited',
                'meta_description' => 'Content for ' . str_replace('-', ' ', $slug) . ' – manage via Admin Panel.',
            ];

            $sort++;
            $name = $def['name'];
            $content = '<p>This page content can be edited from the Admin Panel under <strong>Dynamic Pages</strong>.</p>'
                . '<p>Page: <strong>' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</strong></p>'
                . '<p>Add your content, documents, tables and media here to match the live website.</p>';

            $this->db->table('tbl_page_dynamic')->insert([
                'name'             => $name,
                'slug'             => $slug,
                'content'          => $content,
                'banner'           => $defaultBanner,
                'meta_title'       => $def['meta_title'],
                'meta_description' => $def['meta_description'],
                'lang_id'          => $langId,
                'status'           => 'Active',
            ]);
        }

        echo 'Seeded ' . count($config->slugs) . ' dynamic pages (lang_id=' . $langId . ').' . PHP_EOL;
    }
}
