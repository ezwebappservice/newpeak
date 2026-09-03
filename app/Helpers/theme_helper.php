<?php

/**
 * Theme helpers for frontend templates.
 */

if (! function_exists('theme_asset')) {
    function theme_asset(string $path = ''): string
    {
        return base_url('assets/' . ltrim($path, '/'));
    }
}

if (! function_exists('theme_current_controller')) {
    function theme_current_controller(): string
    {
        return strtolower(substr(strrchr(\Config\Services::router()->controllerName(), '\\'), 1));
    }
}

if (! function_exists('theme_is_home')) {
    function theme_is_home(): bool
    {
        return ($GLOBALS['peak_current_page'] ?? '') === 'home'
            || theme_current_controller() === 'home';
    }
}

if (! function_exists('peak_img')) {
    function peak_img(string $path = ''): string
    {
        $path = str_replace('\\', '/', ltrim($path, '/'));
        $path = preg_replace('#^image/+#', '', $path) ?? $path;
        $segments = array_map('rawurlencode', array_filter(explode('/', $path), static fn ($part) => $part !== ''));

        return base_url('assets/images/peak/' . implode('/', $segments));
    }
}

if (! function_exists('peak_page')) {
    function peak_page(): string
    {
        return (string) ($GLOBALS['peak_current_page'] ?? theme_current_controller());
    }
}

if (! function_exists('peak_nav_active')) {
    function peak_nav_active(string ...$pages): string
    {
        return in_array(peak_page(), $pages, true) ? ' active' : '';
    }
}

if (! function_exists('peak_site_email')) {
    function peak_site_email(?array $setting = null): string
    {
        $email = trim((string) ($setting['top_bar_email'] ?? ''));

        return $email !== '' ? $email : 'hello@peakpotentialacademy.com';
    }
}

if (! function_exists('peak_site_phone')) {
    function peak_site_phone(?array $setting = null): string
    {
        $phone = trim((string) ($setting['top_bar_phone'] ?? ''));

        return $phone !== '' ? $phone : '+91 99012 34567';
    }
}

if (! function_exists('peak_site_phone_href')) {
    function peak_site_phone_href(?array $setting = null): string
    {
        return preg_replace('/[^\d+]/', '', peak_site_phone($setting)) ?? '';
    }
}

if (! function_exists('peak_enquiry_url')) {
    function peak_enquiry_url(): string
    {
        return base_url('customer-enquiry-form');
    }
}

if (! function_exists('peak_discovery_attrs')) {
    function peak_discovery_attrs(): string
    {
        return 'href="' . peak_enquiry_url() . '"';
    }
}

if (! function_exists('peak_social_url')) {
    function peak_social_url(array $social, string $network): string
    {
        foreach ($social as $row) {
            $haystack = strtolower(
                ($row['social_icon'] ?? '') . ' ' . ($row['social_url'] ?? '') . ' ' . ($row['social_name'] ?? '')
            );
            if (! str_contains($haystack, strtolower($network))) {
                continue;
            }

            $url = trim((string) ($row['social_url'] ?? ''));
            if ($url !== '' && $url !== '#') {
                return $url;
            }
        }

        return '#';
    }
}

if (! function_exists('peak_home_stats')) {
    /**
     * Homepage stats bar items from CMS, with Peak defaults as fallback.
     *
     * @return list<array{value: string, label: string, icon: string}>
     */
    function peak_home_stats(?array $page_home = null): array
    {
        $page_home = is_array($page_home) ? $page_home : [];
        $defaults = [
            1 => ['value' => '5000+', 'label' => 'Students Trusted', 'icon' => 'school.png'],
            2 => ['value' => '5,000+', 'label' => 'Lives Impacted', 'icon' => 'friends.png'],
            3 => ['value' => 'Top 100', 'label' => 'Global Education Leader', 'icon' => 'trophy.png'],
            4 => ['value' => '15+', 'label' => 'Years Leadership', 'icon' => 'validation.png'],
            5 => ['value' => 'Awardee In', 'label' => '35th World Education Summit, Dubai', 'icon' => 'globe.png'],
        ];

        $stats = [];
        for ($i = 1; $i <= 5; $i++) {
            $value  = trim((string) ($page_home['counter_' . $i . '_value'] ?? ''));
            $suffix = trim((string) ($page_home['counter_' . $i . '_suffix'] ?? ''));
            $label  = trim((string) ($page_home['counter_' . $i . '_title'] ?? ''));
            $display = $value . $suffix;

            $stats[] = [
                'value' => $display !== '' ? $display : $defaults[$i]['value'],
                'label' => $label !== '' ? $label : $defaults[$i]['label'],
                'icon'  => $defaults[$i]['icon'],
            ];
        }

        return $stats;
    }
}

if (! function_exists('peak_video_embed_src')) {
    /**
     * Convert a YouTube/Vimeo URL, video id, or iframe snippet into a safe embed src.
     */
    function peak_video_embed_src(?string $input, string $fallback = 'https://www.youtube.com/embed/Ve2IHBwbzus'): string
    {
        $input = trim((string) $input);
        if ($input === '') {
            return $fallback;
        }

        if (preg_match('/\bsrc\s*=\s*["\']([^"\']+)["\']/i', $input, $match)) {
            $input = html_entity_decode($match[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        if (preg_match('~youtu\.be/([a-zA-Z0-9_-]{11})~', $input, $match)
            || preg_match('~youtube(?:-nocookie)?\.com/(?:embed/|shorts/|watch\?.*?v=)([a-zA-Z0-9_-]{11})~', $input, $match)
        ) {
            return 'https://www.youtube.com/embed/' . $match[1];
        }

        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $input)) {
            return 'https://www.youtube.com/embed/' . $input;
        }

        if (preg_match('~(?:player\.)?vimeo\.com/(?:video/)?(\d+)~', $input, $match)) {
            return 'https://player.vimeo.com/video/' . $match[1];
        }

        return $fallback;
    }
}

if (! function_exists('peak_cms_url')) {
    function peak_cms_url(?string $url, string $fallback = ''): string
    {
        $url = trim((string) $url);
        if ($url === '') {
            return $fallback;
        }

        if (preg_match('#^(https?:)?//#i', $url) || str_starts_with($url, '#') || str_starts_with($url, 'mailto:') || str_starts_with($url, 'tel:')) {
            return $url;
        }

        return base_url(ltrim($url, '/'));
    }
}

if (! function_exists('peak_home_hero')) {
    /**
     * Homepage hero copy from CMS, with Peak defaults as fallback.
     *
     * @return array{
     *   visible: bool,
     *   eyebrow: string,
     *   prefix: string,
     *   highlight: string,
     *   suffix: string,
     *   lead: string,
     *   btn1_text: string,
     *   btn1_url: string,
     *   btn2_text: string,
     *   btn2_url: string,
     *   features: list<array{icon: string, label: string}>,
     *   card_name: string,
     *   card_role: string,
     *   card_org: string,
     *   card_badge: string,
     *   tab_text: string,
     *   photo: string,
     *   photo_alt: string
     * }
     */
    function peak_home_hero(?array $page_home = null, ?array $page_home_lang_independent = null): array
    {
        $page_home = is_array($page_home) ? $page_home : [];
        $independent = is_array($page_home_lang_independent) ? $page_home_lang_independent : [];

        $val = static function (string $key, string $default) use ($page_home): string {
            $value = trim((string) ($page_home[$key] ?? ''));

            return $value !== '' ? $value : $default;
        };

        $photoFile = trim((string) ($independent['home_welcome_video_bg'] ?? ''));

        return [
            'visible'    => ($independent['home_hero_status'] ?? 'Show') !== 'Hide',
            'eyebrow'    => $val('hero_badge', 'THE HUMAN POTENTIAL INSTITUTE'),
            'prefix'     => $val('hero_title_prefix', 'Break the'),
            'highlight'  => $val('hero_title_highlight', 'Invisible Loops'),
            'suffix'     => $val('hero_title_suffix', 'Holding You Back.'),
            'lead'       => $val('hero_lead', 'We work with both students and parents to create lasting change. Students build emotional, communication and financial intelligence beyond academics. Parents gain practical tools to manage screens, behaviour and everyday conflict. Together, they build calmer relationships and confident, life-ready children.'),
            'btn1_text'  => $val('hero_btn1_text', 'Book a Discovery Call'),
            'btn1_url'   => peak_cms_url($page_home['hero_btn1_url'] ?? '', peak_enquiry_url()),
            'btn2_text'  => $val('hero_btn2_text', 'Request a Proposal'),
            'btn2_url'   => peak_cms_url($page_home['hero_btn2_url'] ?? '', base_url('contact-us')),
            'features'   => [
                ['icon' => 'mobile-phone.png', 'label' => $val('hero_feature_1_title', "Screen\nAddiction")],
                ['icon' => 'brain.png', 'label' => $val('hero_feature_2_title', "Emotional\nOverwhelm")],
                ['icon' => 'refresh.png', 'label' => $val('hero_feature_3_title', "Limiting\nPatterns")],
            ],
            'card_name'  => $val('hero_card_name', 'Sapna KS'),
            'card_role'  => $val('hero_card_role', 'Emotional Strength Educator'),
            'card_org'   => $val('hero_card_org', 'Founder, Peak Potential Academy'),
            'card_badge' => $val('hero_card_badge', "Top 100 Global\nEducation Leader"),
            'tab_text'   => $val('hero_tab_text', 'Book ₹599 Session'),
            'photo'      => $photoFile !== '' ? theme_upload($photoFile) : peak_img('14 hero section image.png'),
            'photo_alt'  => $val('hero_card_name', 'Sapna KS'),
        ];
    }
}

if (! function_exists('theme_section_url')) {
    function theme_section_url(string $anchor): string
    {
        $anchor = ltrim($anchor, '#');

        return theme_is_home() ? '#' . $anchor : base_url() . '#' . $anchor;
    }
}

if (! function_exists('theme_nav_active')) {
    function theme_nav_active(string $controller): string
    {
        return theme_current_controller() === $controller ? ' active' : '';
    }
}

if (! function_exists('theme_upload')) {
    function theme_upload(?string $filename, string $fallback = ''): string
    {
        if (! empty($filename)) {
            return base_url('public/uploads/' . $filename);
        }

        return $fallback !== '' ? theme_asset($fallback) : '';
    }
}

if (! function_exists('dynamic_page_url')) {
    function dynamic_page_url(string $slug): string
    {
        $slug = trim($slug, '/');

        return match ($slug) {
            'connect'             => function_exists('contact_page_url') ? contact_page_url() : base_url('connect'),
            'latest-news'         => function_exists('news_url') ? news_url() : base_url('latest-news'),
            'leadership-at-srl'   => base_url('leadership-at-srl'),
            'investor-relations'  => base_url('investor-relations'),
            default               => base_url($slug),
        };
    }
}

if (! function_exists('cms_decode_entities')) {
    /** Decode HTML entities from legacy/editor storage before rendering. */
    function cms_decode_entities(string $html): string
    {
        if ($html === '' || (! str_contains($html, '&') && ! str_contains($html, '&#'))) {
            return $html;
        }

        $prev = null;
        $decoded = $html;

        // Repeatedly decode until stable (handles double-encoded CMS content).
        while ($prev !== $decoded) {
            $prev = $decoded;
            $decoded = html_entity_decode($decoded, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        return $decoded;
    }
}

if (! function_exists('cms_sanitize_html')) {
    /**
     * Strip XSS vectors from admin/CMS HTML while keeping safe formatting tags.
     */
    function cms_sanitize_html(string $html): string
    {
        if ($html === '') {
            return '';
        }

        $allowed = '<p><br><hr><strong><b><em><i><u><ul><ol><li><a><h1><h2><h3><h4><h5><h6>'
            . '<blockquote><span><div><img><table><thead><tbody><tr><th><td><sub><sup>';

        $html = strip_tags($html, $allowed);
        $html = preg_replace('/\s(on\w+|formaction|style|xmlns|xml|data-\w+)\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/iu', '', $html);
        $html = preg_replace('/\s(href|src)\s*=\s*("\s*javascript:[^"]*"|\'\s*javascript:[^\']*\'|javascript:[^\s>]+)/iu', '', $html);
        $html = preg_replace('/\s(href|src)\s*=\s*("\s*data:[^"]*"|\'\s*data:[^\']*\'|data:[^\s>]+)/iu', '', $html);

        return $html;
    }
}

if (! function_exists('cms_text')) {
    /** Escape plain text for HTML output (titles, names, labels). */
    function cms_text(?string $text): string
    {
        return esc(cms_decode_entities($text ?? ''), 'html');
    }
}

if (! function_exists('cms_attr')) {
    /** Escape for HTML attributes (href, src, alt, value). */
    function cms_attr(?string $text): string
    {
        return esc(cms_decode_entities($text ?? ''), 'attr');
    }
}

if (! function_exists('cms_html')) {
    /** Safely output sanitized CMS/admin HTML content. */
    function cms_html(?string $html): string
    {
        if ($html === null || trim($html) === '') {
            return '';
        }

        return cms_sanitize_html(cms_decode_entities($html));
    }
}

if (! function_exists('cms_excerpt')) {
    /** Plain-text excerpt from HTML (for cards/listings). */
    function cms_excerpt(?string $html, int $maxLength = 0): string
    {
        $text = trim(strip_tags(cms_decode_entities($html ?? '')));
        $text = preg_replace('/\s+/u', ' ', $text);

        if ($maxLength > 0 && mb_strlen($text) > $maxLength) {
            $text = mb_substr($text, 0, $maxLength) . '…';
        }

        return esc($text, 'html');
    }
}

if (! function_exists('cms_multiline')) {
    /** Plain multiline text with line breaks (addresses, hours). */
    function cms_multiline(?string $text): string
    {
        return nl2br(esc(strip_tags(cms_decode_entities($text ?? '')), 'html'), false);
    }
}

if (! function_exists('cms_internal_links')) {
    /**
     * Rewrite href="page-slug" to full URLs for known dynamic pages.
     */
    function cms_internal_links(string $html): string
    {
        if ($html === '') {
            return $html;
        }

        $slugs = array_merge(
            config(\Config\ShivalikPages::class)->slugs,
            config(\Config\ShivalikPages::class)->moduleSlugs
        );

        foreach ($slugs as $slug) {
            $url = dynamic_page_url($slug);
            $html = str_replace('href="' . $slug . '"', 'href="' . esc($url, 'attr') . '"', $html);
        }

        return $html;
    }
}

if (! function_exists('about_page_image')) {
    function about_page_image(string $filename): string
    {
        return base_url('public/uploads/about-pages/' . ltrim($filename, '/'));
    }
}

if (! function_exists('cms_page_content')) {
    /**
     * Render dynamic page HTML: internal links + about-page image placeholders.
     */
    function cms_page_content(string $html): string
    {
        if ($html === '') {
            return $html;
        }

        $html = cms_sanitize_html(cms_decode_entities($html));
        $html = cms_internal_links($html);
        // CMS blocks must not use scroll-reveal classes (editor strips data-reveal and hides content).
        $html = preg_replace_callback(
            '/\sclass="([^"]*)"/',
            static function (array $matches): string {
                $classes = trim(preg_replace('/\s+/', ' ', preg_replace('/\breveal\b/', '', $matches[1])));

                return $classes !== '' ? ' class="' . $classes . '"' : '';
            },
            $html
        );
        $html = preg_replace('/\sdata-reveal(?:="[^"]*")?(?:\sdata-reveal-delay="[^"]*")?/i', '', $html);
        $html = preg_replace('/\sdata-reveal-delay="[^"]*"/i', '', $html);
        $html = preg_replace('#\{about-page:([^}]+)\}#', base_url('public/uploads/about-pages/') . '$1', $html);
        $html = preg_replace('#\{business-unit:([^}]+)\}#', base_url('public/uploads/business-units/') . '$1', $html);

        return preg_replace('#\{products:([^}]+)\}#', base_url('public/uploads/products/') . '$1', $html);
    }
}

if (! function_exists('page_dynamic_banner')) {
    function page_dynamic_banner(?string $banner): string
    {
        if ($banner === null || $banner === '') {
            return theme_asset('images/hero-bg.jpg');
        }

        if (str_starts_with($banner, 'about-pages/') || str_starts_with($banner, 'business-units/') || str_starts_with($banner, 'products/')) {
            return base_url('public/uploads/' . $banner);
        }

        return theme_upload($banner);
    }
}

if (! function_exists('theme_nav_is_active')) {
    function theme_nav_is_active(?string $slug): string
    {
        if ($slug === null || $slug === '') {
            return '';
        }

        $current = $GLOBALS['theme_current_page_slug'] ?? null;
        $investorSlug = $GLOBALS['theme_investor_nav_slug'] ?? null;

        if ($investorSlug !== null && $slug === $investorSlug) {
            return ' active';
        }

        if ($current === null && theme_current_controller() === 'page') {
            $segments = \Config\Services::request()->getUri()->getSegments();
            $current = end($segments) ?: null;
        }

        return ($current === $slug) ? ' active' : '';
    }
}
