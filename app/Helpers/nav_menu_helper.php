<?php

if (! function_exists('nav_menu_build_tree')) {
    /**
     * @param list<array<string, mixed>> $rows
     * @return list<array<string, mixed>>
     */
    function nav_menu_build_tree(array $rows, int $parentId = 0): array
    {
        $branch = [];

        foreach ($rows as $row) {
            if ((int) ($row['parent_id'] ?? 0) !== $parentId) {
                continue;
            }

            $children = nav_menu_build_tree($rows, (int) $row['id']);
            $item = [
                'id'          => (int) $row['id'],
                'label'       => $row['label'] ?? '',
                'slug'        => $row['slug'] ?? null,
                'link_type'   => $row['link_type'] ?? 'page',
                'custom_url'  => $row['custom_url'] ?? null,
                'meta_title'  => $row['meta_title'] ?? null,
                'meta_keyword'=> $row['meta_keyword'] ?? null,
                'meta_description' => $row['meta_description'] ?? null,
            ];

            if ($children !== []) {
                $item['children'] = $children;
            }

            $branch[] = $item;
        }

        return $branch;
    }
}

if (! function_exists('nav_menu_item_href')) {
    function nav_menu_item_href(array $item): string
    {
        $linkType = $item['link_type'] ?? 'page';

        if ($linkType === 'url' && ! empty($item['custom_url'])) {
            $url = trim($item['custom_url']);
            if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://') || str_starts_with($url, '//')) {
                return $url;
            }

            return base_url(ltrim($url, '/'));
        }

        if ($linkType === 'none' || empty($item['slug'])) {
            return '#';
        }

        return dynamic_page_url($item['slug']);
    }
}

if (! function_exists('nav_menu_slug_is_linkable')) {
    function nav_menu_slug_is_linkable(?string $slug): bool
    {
        if ($slug === null || $slug === '') {
            return false;
        }

        $active = $GLOBALS['active_page_slugs'] ?? [];
        if (! empty($active[$slug])) {
            return true;
        }

        $moduleSlugs = config(\Config\ShivalikPages::class)->moduleSlugs ?? [];

        return in_array($slug, $moduleSlugs, true);
    }
}

if (! function_exists('nav_menu_page_options')) {
    /** @return list<array{slug: string, name: string, group: string}> */
    function nav_menu_page_options(): array
    {
        $options = [];
        $moduleSlugs = config(\Config\ShivalikPages::class)->moduleSlugs ?? [];
        $moduleLabels = [
            'connect'             => 'Contact (Connect)',
            'latest-news'         => 'Latest News',
            'leadership-at-srl'   => 'Leadership',
            'investor-relations'  => 'Investor Relations',
            'careers'             => 'Careers',
        ];

        foreach ($moduleSlugs as $slug) {
            $options[] = [
                'slug'  => $slug,
                'name'  => $moduleLabels[$slug] ?? ucwords(str_replace('-', ' ', $slug)),
                'group' => 'Module Pages',
            ];
        }

        $Model_page = new \App\Models\Model_page();
        foreach ($Model_page->all_for_navigation() as $row) {
            $options[] = [
                'slug'  => $row['slug'],
                'name'  => $row['name'],
                'group' => 'Dynamic Pages',
            ];
        }

        return $options;
    }
}

if (! function_exists('nav_menu_meta_for_slug')) {
    function nav_menu_meta_for_slug(string $slug): ?array
    {
        static $cache = [];
        if (isset($cache[$slug])) {
            return $cache[$slug];
        }

        $Model_nav_menu = new \App\Models\Model_nav_menu();
        $cache[$slug] = $Model_nav_menu->meta_for_slug($slug);

        return $cache[$slug];
    }
}
