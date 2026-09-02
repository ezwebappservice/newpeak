<?php

if (! function_exists('upload_dir')) {
    /**
     * Absolute path to public/uploads (creates directory if missing).
     */
    function upload_dir(string $subdir = '', bool $create = true): string
    {
        $subdir = $subdir !== '' ? trim(str_replace('\\', '/', $subdir), '/') . '/' : '';

        $dir = (defined('FCPATH') ? FCPATH : ROOTPATH . 'public/') . 'uploads/' . $subdir;

        if ($create && ! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        return $dir;
    }
}

if (! function_exists('upload_file_path')) {
    /**
     * Absolute path to a file inside public/uploads.
     */
    function upload_file_path(string $filename, string $subdir = ''): string
    {
        return upload_dir($subdir) . $filename;
    }
}

if (! function_exists('move_uploaded_to_uploads')) {
    /**
     * Move an uploaded temp file into public/uploads.
     */
    function move_uploaded_to_uploads(string $tmpPath, string $filename, string $subdir = ''): bool
    {
        if (! function_exists('upload_blocked_extension')) {
            helper('security');
        }

        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if ($ext === '' || upload_blocked_extension($ext)) {
            return false;
        }

        return move_uploaded_file($tmpPath, upload_file_path($filename, $subdir));
    }
}

if (! function_exists('safe_unlink_upload')) {
    /**
     * Remove an uploaded file when it exists (prevents errors on missing files).
     */
    function safe_unlink_upload(?string $filename, string $subdir = ''): void
    {
        if ($filename === null || $filename === '') {
            return;
        }

        $path = upload_file_path($filename, $subdir);

        if (is_file($path)) {
            unlink($path);
        }
    }
}
