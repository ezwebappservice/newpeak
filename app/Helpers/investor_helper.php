<?php

if (! function_exists('investor_config')) {
    function investor_config(): \Config\Investor
    {
        return config(\Config\Investor::class);
    }
}

if (! function_exists('investor_storage_dir')) {
    function investor_storage_dir(bool $create = true): string
    {
        $dir = WRITEPATH . 'investor_documents/';

        if ($create && ! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        return $dir;
    }
}

if (! function_exists('investor_storage_path')) {
    function investor_storage_path(string $filename): string
    {
        return investor_storage_dir() . $filename;
    }
}

if (! function_exists('move_investor_upload')) {
    function move_investor_upload(string $tmpPath, string $filename): bool
    {
        return move_uploaded_file($tmpPath, investor_storage_path($filename));
    }
}

if (! function_exists('safe_unlink_investor')) {
    function safe_unlink_investor(?string $filename): void
    {
        if ($filename === null || $filename === '') {
            return;
        }

        $path = investor_storage_path($filename);

        if (is_file($path)) {
            unlink($path);
        }
    }
}

if (! function_exists('investor_current_financial_year')) {
    /**
     * Indian financial year label, e.g. 2025-26 (April–March).
     */
    function investor_current_financial_year(?int $timestamp = null): string
    {
        $timestamp = $timestamp ?? time();
        $month = (int) date('n', $timestamp);
        $year  = (int) date('Y', $timestamp);

        if ($month >= 4) {
            $start = $year;
        } else {
            $start = $year - 1;
        }

        $endShort = substr((string) ($start + 1), -2);

        return $start . '-' . $endShort;
    }
}

if (! function_exists('investor_financial_years')) {
    /**
     * @return list<string> e.g. ['2016-17', ..., '2025-26']
     */
    function investor_financial_years(?int $count = null): array
    {
        $count = $count ?? investor_config()->yearRange;
        $current = investor_current_financial_year();
        $startYear = (int) explode('-', $current)[0];
        $years = [];

        for ($i = $count - 1; $i >= 0; $i--) {
            $y = $startYear - $i;
            $years[] = $y . '-' . substr((string) ($y + 1), -2);
        }

        return $years;
    }
}

if (! function_exists('investor_calendar_years')) {
    /**
     * @return list<string> e.g. ['2016', ..., '2026']
     */
    function investor_calendar_years(?int $count = null): array
    {
        $count = $count ?? investor_config()->yearRange;
        $current = (int) date('Y');
        $years = [];

        for ($i = $count - 1; $i >= 0; $i--) {
            $years[] = (string) ($current - $i);
        }

        return $years;
    }
}

if (! function_exists('investor_year_options')) {
    /**
     * Combined year options for dropdowns.
     *
     * @return array<string, list<string>>
     */
    function investor_year_options(?int $count = null): array
    {
        return [
            'Financial Year' => investor_financial_years($count),
            'Calendar Year'  => investor_calendar_years($count),
        ];
    }
}

if (! function_exists('investor_flat_year_list')) {
    /**
     * Flat list of all year values (financial + calendar).
     *
     * @return list<string>
     */
    function investor_flat_year_list(?int $count = null): array
    {
        $options = investor_year_options($count);
        $flat = [];

        foreach ($options as $group) {
            foreach ($group as $year) {
                $flat[] = $year;
            }
        }

        return array_values(array_unique($flat));
    }
}

if (! function_exists('investor_is_allowed_extension')) {
    function investor_is_allowed_extension(string $ext): bool
    {
        $ext = strtolower(trim($ext, '.'));
        $cfg = investor_config();

        if ($ext === '' || in_array($ext, $cfg->blockedExtensions, true)) {
            return false;
        }

        return in_array($ext, $cfg->allowedExtensions, true);
    }
}

if (! function_exists('investor_validate_upload')) {
    /**
     * @return array{valid: bool, error: string, ext: string}
     */
    function investor_validate_upload(array $file): array
    {
        $result = ['valid' => false, 'error' => '', 'ext' => ''];

        if (empty($file['name']) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            $result['error'] = 'Please select a file to upload.';

            return $result;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (! investor_is_allowed_extension($ext)) {
            $result['error'] = 'File type not allowed. Executable and unsupported formats are blocked.';

            return $result;
        }

        $maxBytes = investor_config()->maxUploadSizeKb * 1024;

        if (($file['size'] ?? 0) > $maxBytes) {
            $maxMb = round(investor_config()->maxUploadSizeKb / 1024, 1);
            $result['error'] = 'File size exceeds the maximum allowed size of ' . $maxMb . ' MB.';

            return $result;
        }

        $result['valid'] = true;
        $result['ext']   = $ext;

        return $result;
    }
}

if (! function_exists('investor_unique_filename')) {
    function investor_unique_filename(string $ext): string
    {
        return 'inv-' . bin2hex(random_bytes(16)) . '.' . strtolower($ext);
    }
}

if (! function_exists('investor_format_file_size')) {
    function investor_format_file_size(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        }

        if ($bytes >= 1024) {
            return round($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' B';
    }
}

if (! function_exists('investor_sort_categories')) {
    /**
     * @param list<array<string, mixed>> $categories
     * @return list<array<string, mixed>>
     */
    function investor_sort_categories(array $categories): array
    {
        usort($categories, static function ($a, $b) {
            $sort = ((int) ($a['sort_order'] ?? 0)) <=> ((int) ($b['sort_order'] ?? 0));

            return $sort !== 0 ? $sort : strcmp((string) ($a['category_name'] ?? ''), (string) ($b['category_name'] ?? ''));
        });

        return $categories;
    }
}

if (! function_exists('investor_category_tree')) {
    /**
     * Active investor categories grouped for frontend navigation and landing pages.
     *
     * @return array{
     *     parents: list<array<string, mixed>>,
     *     children: array<int, list<array<string, mixed>>>,
     *     standalone: list<array<string, mixed>>
     * }
     */
    function investor_category_tree(): array
    {
        $model = new \App\Models\Model_investor();
        $parents = $model->active_parent_categories();
        $children = [];
        $standalone = [];

        foreach ($parents as $parent) {
            $parentId = (int) $parent['id'];
            $childRows = $model->active_children($parentId);

            if ($childRows !== []) {
                $children[$parentId] = $childRows;
            } else {
                $standalone[] = $parent;
            }
        }

        return [
            'parents'    => $parents,
            'children'   => $children,
            'standalone' => $standalone,
        ];
    }
}

if (! function_exists('investor_category_groups')) {
    /**
     * Build parent/child groups for category dropdowns.
     *
     * @param list<array<string, mixed>> $categories
     * @return array{
     *     parents: list<array<string, mixed>>,
     *     children: array<int, list<array<string, mixed>>>,
     *     standalone: list<array<string, mixed>>
     * }
     */
    function investor_category_groups(array $categories): array
    {
        $parents = [];
        $children = [];

        foreach ($categories as $category) {
            $parentId = (int) ($category['parent_id'] ?? 0);

            if ($parentId > 0) {
                $children[$parentId][] = $category;
            }
        }

        foreach ($categories as $category) {
            $parentId = (int) ($category['parent_id'] ?? 0);

            if ($parentId > 0) {
                continue;
            }

            $parents[] = $category;
        }

        $parents = investor_sort_categories($parents);

        foreach ($children as $parentId => $childRows) {
            $children[$parentId] = investor_sort_categories($childRows);
        }

        $standalone = [];

        foreach ($parents as $category) {
            $id = (int) $category['id'];

            if (empty($children[$id])) {
                $standalone[] = $category;
            }
        }

        return [
            'parents'    => $parents,
            'children'   => $children,
            'standalone' => $standalone,
        ];
    }
}

if (! function_exists('investor_category_label')) {
    function investor_category_label(array $category): string
    {
        if (! empty($category['parent_name'])) {
            return $category['parent_name'] . ' → ' . $category['category_name'];
        }

        return (string) ($category['category_name'] ?? '');
    }
}

if (! function_exists('investor_category_icon')) {
    function investor_category_icon(array $category): string
    {
        $slug = strtolower((string) ($category['category_slug'] ?? ''));
        $name = strtolower((string) ($category['category_name'] ?? ''));

        $map = [
            'annual'        => 'bi-journal-bookmark',
            'financial'     => 'bi-graph-up-arrow',
            'quarter'       => 'bi-bar-chart-line',
            'sharehold'     => 'bi-pie-chart',
            'governance'    => 'bi-shield-check',
            'polic'         => 'bi-file-earmark-ruled',
            'notice'        => 'bi-megaphone',
            'announcement'  => 'bi-broadcast',
            'presentation'  => 'bi-easel',
            'disclosure'    => 'bi-clipboard-data',
            'regulation'    => 'bi-journal-check',
            'compliance'    => 'bi-patch-check',
            'dividend'      => 'bi-cash-stack',
            'report'        => 'bi-file-earmark-pdf',
        ];

        foreach ($map as $needle => $icon) {
            if (str_contains($slug, $needle) || str_contains($name, $needle)) {
                return $icon;
            }
        }

        return 'bi-folder2-open';
    }
}

if (! function_exists('investor_category_blurb')) {
    function investor_category_blurb(array $category): string
    {
        $slug = strtolower((string) ($category['category_slug'] ?? ''));
        $name = strtolower((string) ($category['category_name'] ?? ''));

        $blurbs = [
            'annual'       => 'Integrated annual reports, financial statements and company performance summaries.',
            'financial'    => 'Quarterly and annual financial results, earnings updates and related filings.',
            'sharehold'    => 'Shareholding pattern disclosures and ownership structure reports.',
            'governance'   => 'Board composition, governance policies and regulatory compliance documents.',
            'polic'        => 'Corporate policies, codes of conduct and statutory disclosures.',
            'notice'       => 'Official notices, announcements and communications to shareholders.',
            'presentation' => 'Investor presentations, company overviews and briefing materials.',
            'disclosure'   => 'Regulatory disclosures and mandatory investor information.',
            'compliance'   => 'Compliance reports and statutory filings for investors.',
            'dividend'     => 'Dividend-related notices and unclaimed dividend information.',
        ];

        foreach ($blurbs as $needle => $text) {
            if (str_contains($slug, $needle) || str_contains($name, $needle)) {
                return $text;
            }
        }

        return 'Browse downloadable investor documents and regulatory filings for this section.';
    }
}

if (! function_exists('investor_document_count_label')) {
    function investor_document_count_label(int $count): string
    {
        if ($count <= 0) {
            return 'Documents coming soon';
        }

        return $count . ' document' . ($count === 1 ? '' : 's') . ' available';
    }
}

if (! function_exists('investor_parent_category_badge')) {
    function investor_parent_category_badge(array $parent): string
    {
        $childCount = (int) ($parent['child_count'] ?? 0);

        if ($childCount > 0) {
            return $childCount . ' sub-section' . ($childCount === 1 ? '' : 's');
        }

        return investor_document_count_label((int) ($parent['document_count'] ?? 0));
    }
}

if (! function_exists('investor_parent_category_cta')) {
    function investor_parent_category_cta(array $parent): string
    {
        return ((int) ($parent['child_count'] ?? 0)) > 0 ? 'Browse Sections' : 'View Documents';
    }
}

if (! function_exists('investor_make_category_slug')) {
    function investor_make_category_slug(string $name, ?int $excludeId = null): string
    {
        $slug = url_title($name, '-', true);
        $slug = $slug !== '' ? $slug : 'investor-category';

        $db = \Config\Database::connect();
        $base = $slug;
        $suffix = 1;

        while (true) {
            $builder = $db->table('investor_categories')->where('category_slug', $slug);

            if ($excludeId !== null) {
                $builder->where('id !=', $excludeId);
            }

            if ($builder->countAllResults() === 0) {
                return $slug;
            }

            $suffix++;
            $slug = $base . '-' . $suffix;
        }
    }
}

if (! function_exists('investor_category_path')) {
    function investor_category_path(array $category): string
    {
        $slug = $category['category_slug'] ?? '';

        return $slug !== '' ? 'investor-relations/category/' . $slug : 'investor-relations';
    }
}

if (! function_exists('investor_documents_path')) {
    function investor_documents_path(array $category): string
    {
        $slug = $category['category_slug'] ?? '';

        return $slug !== '' ? 'investor-relations/documents/' . $slug : 'investor-relations';
    }
}

if (! function_exists('investor_category_url')) {
    function investor_category_url(array $category): string
    {
        return base_url(investor_category_path($category));
    }
}

if (! function_exists('investor_documents_url')) {
    function investor_documents_url(array $category): string
    {
        return base_url(investor_documents_path($category));
    }
}

if (! function_exists('investor_nav_slug_category')) {
    function investor_nav_slug_category(array $category): string
    {
        return 'investor-cat-' . ($category['category_slug'] ?? $category['id']);
    }
}

if (! function_exists('investor_nav_slug_document')) {
    function investor_nav_slug_document(array $category): string
    {
        return 'investor-doc-' . ($category['category_slug'] ?? $category['id']);
    }
}

if (! function_exists('investor_set_nav_context')) {
    function investor_set_nav_context(string $slug): void
    {
        $GLOBALS['theme_investor_nav_slug'] = $slug;
        $GLOBALS['theme_current_page_slug'] = $slug;
    }
}

if (! function_exists('investor_nav_menu_children')) {
    /**
     * @return list<array<string, mixed>>
     */
    function investor_nav_menu_children(): array
    {
        $groups = investor_category_tree();

        if ($groups['parents'] === []) {
            return [];
        }

        $items = [
            [
                'label'      => 'Investor Overview',
                'link_type'  => 'url',
                'custom_url' => 'investor-relations',
                'slug'       => 'investor-relations',
            ],
        ];

        foreach ($groups['parents'] as $parent) {
            $parentId = (int) $parent['id'];
            $childRows = $groups['children'][$parentId] ?? [];

            if ($childRows !== []) {
                $children = [];

                foreach ($childRows as $child) {
                    $children[] = [
                        'label'      => $child['category_name'],
                        'link_type'  => 'url',
                        'custom_url' => investor_documents_path($child),
                        'slug'       => investor_nav_slug_document($child),
                    ];
                }

                $items[] = [
                    'label'      => $parent['category_name'],
                    'link_type'  => 'url',
                    'custom_url' => investor_category_path($parent),
                    'slug'       => investor_nav_slug_category($parent),
                    'children'   => $children,
                ];
            } else {
                $items[] = [
                    'label'      => $parent['category_name'],
                    'link_type'  => 'url',
                    'custom_url' => investor_documents_path($parent),
                    'slug'       => investor_nav_slug_document($parent),
                ];
            }
        }

        return $items;
    }
}

if (! function_exists('nav_menu_is_investors_root')) {
    function nav_menu_is_investors_root(array $item): bool
    {
        $label = strtolower(trim((string) ($item['label'] ?? '')));

        if ($label === 'investors' || str_contains($label, 'investor relation')) {
            return true;
        }

        if (($item['slug'] ?? '') === 'investor-relations') {
            return true;
        }

        $href = nav_menu_item_href($item);

        return str_contains($href, 'investor-relations');
    }
}

if (! function_exists('nav_menu_merge_investor_categories')) {
    /**
     * @param list<array<string, mixed>> $navTree
     * @return list<array<string, mixed>>
     */
    function nav_menu_merge_investor_categories(array $navTree): array
    {
        $investorChildren = investor_nav_menu_children();

        if ($investorChildren === []) {
            return $navTree;
        }

        foreach ($navTree as $index => $item) {
            if (nav_menu_is_investors_root($item)) {
                $navTree[$index] = array_merge($item, [
                    'link_type'  => 'url',
                    'custom_url' => 'investor-relations',
                    'slug'       => 'investor-relations',
                    'children'   => $investorChildren,
                ]);

                return $navTree;
            }

            if (! empty($item['children'])) {
                $navTree[$index]['children'] = nav_menu_merge_investor_categories($item['children']);

                if (nav_menu_is_investors_root($item)) {
                    $navTree[$index]['children'] = $investorChildren;
                }
            }
        }

        return $navTree;
    }
}
