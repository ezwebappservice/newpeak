<?php

/**
 * Ensures the CodeIgniter writable directory tree exists before Boot runs.
 * Fixes "The WRITEPATH is not set correctly" on new/staging deployments.
 */
function ensure_writable_directory(string $projectRoot): void
{
    $writablePath = $projectRoot . 'writable';

    if (! is_dir($writablePath) && ! @mkdir($writablePath, 0755, true) && ! is_dir($writablePath)) {
        header('HTTP/1.1 503 Service Unavailable.', true, 503);
        echo 'The writable/ directory is missing and could not be created. '
            . 'Upload the writable/ folder from your project and set permissions to 755 or 775.';

        exit(1);
    }

    $subDirs = [
        'cache',
        'logs',
        'session',
        'uploads',
        'debugbar',
        'backups',
        'investor_documents',
    ];

    foreach ($subDirs as $subDir) {
        $path = $writablePath . DIRECTORY_SEPARATOR . $subDir;

        if (! is_dir($path)) {
            @mkdir($path, 0755, true);
        }

        $indexFile = $path . DIRECTORY_SEPARATOR . 'index.html';

        if (! is_file($indexFile)) {
            @file_put_contents($indexFile, '<!DOCTYPE html><title>403 Forbidden</title>');
        }
    }

    if (! is_writable($writablePath)) {
        header('HTTP/1.1 503 Service Unavailable.', true, 503);
        echo 'The writable/ directory exists but is not writable by PHP. '
            . 'Set folder permissions to 755 or 775 on the server.';

        exit(1);
    }
}
