<?php

if (! function_exists('shop_generate_slug')) {
    function shop_generate_slug(string $string): string
    {
        $slug = strtolower(trim($string));
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);

        return trim($slug, '-');
    }
}

if (! function_exists('shop_unique_slug')) {
    function shop_unique_slug(string $slug, callable $existsCheck): string
    {
        $base = $slug;
        $counter = 1;

        while ($existsCheck($slug)) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
