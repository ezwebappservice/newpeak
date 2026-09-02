<?php

if (! function_exists('form_flash_messages')) {
    /**
     * @return array<int, string>
     */
    function form_flash_messages(?string $type = null): array
    {
        if ($type === null) {
            return [];
        }

        $raw = session()->getFlashdata($type);

        if ($raw === null || $raw === '') {
            return [];
        }

        if (is_array($raw)) {
            return array_values(array_filter(array_map('trim', $raw)));
        }

        $text = strip_tags((string) $raw, '<br>');
        $parts = preg_split('/<br\s*\/?>/i', $text) ?: [];

        return array_values(array_filter(array_map(static fn ($line) => trim($line), $parts)));
    }
}

if (! function_exists('form_old_value')) {
    function form_old_value(string $field, string $default = ''): string
    {
        helper('form');

        return (string) (old($field) ?? $default);
    }
}

if (! function_exists('form_redirect_with_errors')) {
    /**
     * @param string|array<int, string> $errors
     */
    function form_redirect_with_errors(string $url, $errors, string $flashKey = 'form_error')
    {
        if (is_string($errors)) {
            $errors = form_flash_messages_from_string($errors);
        }

        return redirect()->to($url)->withInput()->with($flashKey, $errors);
    }
}

if (! function_exists('form_redirect_with_success')) {
    function form_redirect_with_success(string $url, string $message, string $flashKey = 'form_success')
    {
        return redirect()->to($url)->with($flashKey, $message);
    }
}

if (! function_exists('form_flash_messages_from_string')) {
    /**
     * @return array<int, string>
     */
    function form_flash_messages_from_string(string $raw): array
    {
        $text = strip_tags($raw, '<br>');
        $parts = preg_split('/<br\s*\/?>/i', $text) ?: [];

        return array_values(array_filter(array_map(static fn ($line) => trim($line), $parts)));
    }
}
