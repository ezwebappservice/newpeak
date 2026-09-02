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
