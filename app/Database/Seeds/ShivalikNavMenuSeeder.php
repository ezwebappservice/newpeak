<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Config\ShivalikPages;

class ShivalikNavMenuSeeder extends Seeder
{
    public function run()
    {
        if (! $this->db->tableExists('tbl_nav_menu')) {
            echo 'tbl_nav_menu does not exist. Run migrations first.' . PHP_EOL;

            return;
        }

        $langId = 5;
        $langRow = $this->db->table('tbl_lang')->where('lang_default', 'Yes')->get()->getRowArray();
        if ($langRow) {
            $langId = (int) $langRow['lang_id'];
        }

        $this->db->table('tbl_nav_menu')->where('lang_id', $langId)->delete();

        $navigation = config(ShivalikPages::class)->navigation ?? [];
        $sort = 0;
        foreach ($navigation as $item) {
            $this->insertItem($item, 0, $langId, $sort++);
        }

        echo 'Navigation menu seeded with ' . $this->db->table('tbl_nav_menu')->where('lang_id', $langId)->countAllResults() . ' items (lang_id=' . $langId . ').' . PHP_EOL;
    }

    private function insertItem(array $item, int $parentId, int $langId, int $sortOrder): void
    {
        $slug = $item['slug'] ?? null;
        $hasChildren = ! empty($item['children']);
        $linkType = 'page';

        if ($hasChildren && empty($slug)) {
            $linkType = 'none';
        } elseif ($hasChildren && ! empty($slug)) {
            $linkType = 'page';
        } elseif (empty($slug)) {
            $linkType = 'none';
        }

        $this->db->table('tbl_nav_menu')->insert([
            'parent_id'        => $parentId,
            'lang_id'          => $langId,
            'label'            => $item['label'] ?? 'Menu Item',
            'link_type'        => $linkType,
            'slug'             => $slug,
            'custom_url'       => null,
            'sort_order'       => $sortOrder,
            'menu_status'      => 'Show',
            'meta_title'       => null,
            'meta_keyword'     => null,
            'meta_description' => null,
        ]);

        $newId = (int) $this->db->insertID();

        if ($hasChildren) {
            $childSort = 0;
            foreach ($item['children'] as $child) {
                $this->insertItem($child, $newId, $langId, $childSort++);
            }
        }
    }
}
