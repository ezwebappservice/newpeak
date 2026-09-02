<?php

/**
 * Application security helpers — password hashing, rate limiting, safe redirects.
 */

if (! function_exists('admin_hash_password')) {
    function admin_hash_password(string $plain): string
    {
        return password_hash($plain, PASSWORD_DEFAULT);
    }
}

if (! function_exists('admin_is_legacy_password')) {
    function admin_is_legacy_password(string $storedHash): bool
    {
        return strlen($storedHash) === 32
            && ctype_xdigit($storedHash)
            && ! str_starts_with($storedHash, '$');
    }
}

if (! function_exists('admin_verify_password')) {
    function admin_verify_password(string $plain, string $storedHash): bool
    {
        if ($storedHash === '') {
            return false;
        }

        if (admin_is_legacy_password($storedHash)) {
            return hash_equals($storedHash, md5($plain));
        }

        return password_verify($plain, $storedHash);
    }
}

if (! function_exists('admin_password_needs_rehash')) {
    function admin_password_needs_rehash(string $storedHash): bool
    {
        if (admin_is_legacy_password($storedHash)) {
            return true;
        }

        return password_needs_rehash($storedHash, PASSWORD_DEFAULT);
    }
}

if (! function_exists('admin_reset_token')) {
    function admin_reset_token(): string
    {
        return time() . '.' . bin2hex(random_bytes(24));
    }
}

if (! function_exists('admin_reset_token_valid')) {
    function admin_reset_token_valid(string $token, int $ttlSeconds = 3600): bool
    {
        if ($token === '' || ! str_contains($token, '.')) {
            return false;
        }

        [$issuedAt] = explode('.', $token, 2);

        if (! ctype_digit($issuedAt)) {
            return false;
        }

        return (time() - (int) $issuedAt) <= $ttlSeconds;
    }
}

if (! function_exists('sec_client_ip')) {
    function sec_client_ip(): string
    {
        return service('request')->getIPAddress();
    }
}

if (! function_exists('sec_rate_limit_file')) {
    function sec_rate_limit_file(): string
    {
        $dir = WRITEPATH . 'cache';

        if (! is_dir($dir)) {
            mkdir($dir, 0750, true);
        }

        return $dir . '/rate_limits.json';
    }
}

if (! function_exists('sec_rate_limit_load')) {
    function sec_rate_limit_load(): array
    {
        $file = sec_rate_limit_file();

        if (! is_file($file)) {
            return [];
        }

        $data = json_decode((string) file_get_contents($file), true);

        return is_array($data) ? $data : [];
    }
}

if (! function_exists('sec_rate_limit_save')) {
    function sec_rate_limit_save(array $data): void
    {
        file_put_contents(
            sec_rate_limit_file(),
            json_encode($data),
            LOCK_EX
        );
    }
}

if (! function_exists('sec_rate_limit_key')) {
    function sec_rate_limit_key(string $scope, string $identifier): string
    {
        return hash('sha256', strtolower($scope) . '|' . strtolower(trim($identifier)) . '|' . sec_client_ip());
    }
}

if (! function_exists('sec_rate_limit_is_locked')) {
    /**
     * @return array{locked: bool, retry_after: int}
     */
    function sec_rate_limit_is_locked(string $scope, string $identifier, int $maxAttempts = 5, int $lockSeconds = 900): array
    {
        $key = sec_rate_limit_key($scope, $identifier);
        $now = time();
        $data = sec_rate_limit_load();

        if (! isset($data[$key])) {
            return ['locked' => false, 'retry_after' => 0];
        }

        $entry = $data[$key];

        if (! empty($entry['locked_until']) && (int) $entry['locked_until'] > $now) {
            return [
                'locked'      => true,
                'retry_after' => (int) $entry['locked_until'] - $now,
            ];
        }

        if (! empty($entry['locked_until']) && (int) $entry['locked_until'] <= $now) {
            unset($data[$key]);
            sec_rate_limit_save($data);
        }

        if ((int) ($entry['attempts'] ?? 0) >= $maxAttempts) {
            $data[$key] = [
                'attempts'     => (int) $entry['attempts'],
                'locked_until' => $now + $lockSeconds,
            ];
            sec_rate_limit_save($data);

            return ['locked' => true, 'retry_after' => $lockSeconds];
        }

        return ['locked' => false, 'retry_after' => 0];
    }
}

if (! function_exists('sec_rate_limit_hit')) {
    function sec_rate_limit_hit(string $scope, string $identifier, int $maxAttempts = 5, int $lockSeconds = 900): void
    {
        $key = sec_rate_limit_key($scope, $identifier);
        $now = time();
        $data = sec_rate_limit_load();

        $attempts = (int) ($data[$key]['attempts'] ?? 0) + 1;

        $data[$key] = [
            'attempts'     => $attempts,
            'locked_until' => $attempts >= $maxAttempts ? $now + $lockSeconds : 0,
        ];

        sec_rate_limit_save($data);
    }
}

if (! function_exists('sec_rate_limit_clear')) {
    function sec_rate_limit_clear(string $scope, string $identifier): void
    {
        $key = sec_rate_limit_key($scope, $identifier);
        $data = sec_rate_limit_load();

        if (isset($data[$key])) {
            unset($data[$key]);
            sec_rate_limit_save($data);
        }
    }
}

if (! function_exists('safe_redirect_back')) {
    function safe_redirect_back(string $fallback = ''): never
    {
        $fallback = $fallback !== '' ? $fallback : base_url();
        $referer = (string) service('request')->getServer('HTTP_REFERER');

        if ($referer !== '') {
            $siteHost = parse_url(base_url(), PHP_URL_HOST);
            $refHost  = parse_url($referer, PHP_URL_HOST);

            if ($siteHost && $refHost && strcasecmp($siteHost, $refHost) === 0) {
                redirect($referer);
            }
        }

        redirect($fallback);
    }
}

if (! function_exists('upload_blocked_extension')) {
    function upload_blocked_extension(string $ext): bool
    {
        $ext = strtolower(trim($ext, '.'));

        return in_array($ext, [
            'php', 'php3', 'php4', 'php5', 'php7', 'php8', 'phtml', 'phar',
            'cgi', 'pl', 'asp', 'aspx', 'jsp', 'js', 'html', 'htm', 'shtml',
            'htaccess', 'ini', 'sh', 'bash', 'exe', 'dll', 'svg',
        ], true);
    }
}

if (! function_exists('validate_uploaded_image')) {
    /**
     * @return array{ok: bool, ext: string, error: string}
     */
    function validate_uploaded_image(string $tmpPath, string $originalName): array
    {
        if ($tmpPath === '' || ! is_uploaded_file($tmpPath)) {
            return ['ok' => false, 'ext' => '', 'error' => 'Invalid upload.'];
        }

        $info = @getimagesize($tmpPath);

        if ($info === false) {
            return ['ok' => false, 'ext' => '', 'error' => 'File is not a valid image.'];
        }

        $map = [
            IMAGETYPE_JPEG => 'jpg',
            IMAGETYPE_PNG  => 'png',
            IMAGETYPE_GIF  => 'gif',
        ];

        if (! isset($map[$info[2]])) {
            return ['ok' => false, 'ext' => '', 'error' => 'Unsupported image type.'];
        }

        $ext = $map[$info[2]];

        if (upload_blocked_extension($ext)) {
            return ['ok' => false, 'ext' => '', 'error' => 'File type is not allowed.'];
        }

        return ['ok' => true, 'ext' => $ext, 'error' => ''];
    }
}
