<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Config\ShivalikPages;

class ShivalikFocusPagesContentSeeder extends Seeder
{
    public function run()
    {
        $configs = [
            \Config\ShivalikBusinessUnitPageContent::class,
            \Config\ShivalikProductsPageContent::class,
        ];

        $defs = config(ShivalikPages::class)->definitions;

        $langRow = $this->db->table('tbl_lang')
            ->where('lang_default', 'Yes')
            ->get()
            ->getRowArray();
        $langId = (int) ($langRow['lang_id'] ?? 5);

        $defaultBanner = is_file(FCPATH . 'uploads/banner_about.jpg')
            ? 'banner_about.jpg'
            : 'page-dynamic-banner-1.jpg';

        $updated = 0;
        $created = 0;

        foreach ($configs as $configClass) {
            $cfg = config($configClass);
            foreach ($cfg->pages as $slug => $content) {
                $def = $defs[$slug] ?? [
                    'name'             => ucwords(str_replace('-', ' ', $slug)),
                    'meta_title'       => ucwords(str_replace('-', ' ', $slug)) . ' | Peak Potential',
                    'meta_description' => 'Peak Potential – ' . str_replace('-', ' ', $slug) . '.',
                ];

                $existing = $this->db->table('tbl_page_dynamic')
                    ->where('slug', $slug)
                    ->where('lang_id', $langId)
                    ->get()
                    ->getRowArray();

                $payload = [
                    'name'             => $def['name'],
                    'content'          => $content,
                    'meta_title'       => $def['meta_title'],
                    'meta_description' => $def['meta_description'],
                    'status'           => 'Active',
                ];

                if (isset($cfg->banners[$slug])) {
                    $payload['banner'] = $cfg->banners[$slug];
                }

                if ($existing) {
                    $this->db->table('tbl_page_dynamic')
                        ->where('id', $existing['id'])
                        ->update($payload);
                    $updated++;
                } else {
                    $payload['slug']    = $slug;
                    $payload['banner']  = $cfg->banners[$slug] ?? $defaultBanner;
                    $payload['lang_id'] = $langId;
                    $this->db->table('tbl_page_dynamic')->insert($payload);
                    $created++;
                }
            }
        }

        echo 'Focus/product pages: updated ' . $updated . ', created ' . $created . ' (lang_id=' . $langId . ').' . PHP_EOL;
    }
}
