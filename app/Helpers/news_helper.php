<?php

if (! function_exists('news_generate_slug')) {
    function news_generate_slug(string $string): string
    {
        $slug = strtolower(trim($string));
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);

        return trim($slug, '-');
    }
}

if (! function_exists('news_unique_slug')) {
    function news_unique_slug(string $slug, ?int $excludeId = null): string
    {
        $db = \Config\Database::connect();
        $base = $slug !== '' ? $slug : 'news';
        $candidate = $base;
        $counter = 1;

        while (true) {
            $builder = $db->table('tbl_news')->where('news_slug', $candidate);

            if ($excludeId !== null) {
                $builder->where('news_id !=', $excludeId);
            }

            if ($builder->countAllResults() === 0) {
                return $candidate;
            }

            $candidate = $base . '-' . $counter;
            $counter++;
        }
    }
}

if (! function_exists('news_url')) {
    function news_url(?string $slug = null): string
    {
        if ($slug === null || $slug === '') {
            return base_url('latest-news');
        }

        return base_url('latest-news/' . trim($slug, '/'));
    }
}

if (! function_exists('news_format_date')) {
    function news_format_date(?string $date, string $format = 'F j, Y'): string
    {
        if ($date === null || $date === '') {
            return '';
        }

        $ts = strtotime($date);

        return $ts ? date($format, $ts) : $date;
    }
}

if (! function_exists('news_resolve_slug')) {
    function news_resolve_slug(string $title, ?string $provided = null, ?int $excludeId = null): string
    {
        $slug = news_generate_slug($provided !== null && trim($provided) !== '' ? $provided : $title);

        if ($slug === '') {
            $slug = 'news';
        }

        return news_unique_slug($slug, $excludeId);
    }
}
