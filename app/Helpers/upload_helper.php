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

        $destination = upload_file_path($filename, $subdir);
        $moved = move_uploaded_file($tmpPath, $destination);
        if ($moved) {
            peak_write_webp($destination);
        }

        return $moved;
    }
}

if (! function_exists('peak_write_webp')) {
    /**
     * Write a compressed sibling .webp for raster uploads.
     */
    function peak_write_webp(string $path, int $maxWidth = 1600, int $quality = 78): void
    {
        if (! is_file($path)) {
            return;
        }

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (! in_array($ext, ['png', 'jpg', 'jpeg'], true)) {
            return;
        }

        $webpPath = (string) preg_replace('/\.(png|jpe?g)$/i', '.webp', $path);

        try {
            if (class_exists(\Imagick::class)) {
                $image = new \Imagick($path);
                if ($image->getImageWidth() > $maxWidth) {
                    $image->resizeImage($maxWidth, 0, \Imagick::FILTER_LANCZOS, 1);
                }
                $image->stripImage();
                $image->setImageFormat('webp');
                $image->setImageCompressionQuality($quality);
                $image->writeImage($webpPath);
                $image->clear();
                $image->destroy();

                return;
            }

            if (! function_exists('imagewebp')) {
                return;
            }

            $source = match ($ext) {
                'png' => imagecreatefrompng($path),
                default => imagecreatefromjpeg($path),
            };
            if ($source === false) {
                return;
            }

            $width = imagesx($source);
            $height = imagesy($source);
            if ($width > $maxWidth) {
                $newHeight = (int) round($height * ($maxWidth / $width));
                $resized = imagecreatetruecolor($maxWidth, $newHeight);
                if ($resized === false) {
                    imagedestroy($source);

                    return;
                }
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
                imagecopyresampled($resized, $source, 0, 0, 0, 0, $maxWidth, $newHeight, $width, $height);
                imagedestroy($source);
                $source = $resized;
            }

            imagewebp($source, $webpPath, $quality);
            imagedestroy($source);
        } catch (\Throwable $e) {
            log_message('debug', 'WebP conversion skipped: ' . $e->getMessage());
        }
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

        $webpPath = (string) preg_replace('/\.(png|jpe?g|gif)$/i', '.webp', $path);
        if ($webpPath !== $path && is_file($webpPath)) {
            unlink($webpPath);
        }
    }
}
