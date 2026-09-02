<?php

use CodeIgniter\HTTP\IncomingRequest;

if (! function_exists('form_antispam_prepare')) {
    /**
     * @return array{form_key: string, captcha_prompt: string}
     */
    function form_antispam_prepare(string $formKey): array
    {
        $a = random_int(2, 12);
        $b = random_int(1, 9);

        session()->set('antispam_ts_' . $formKey, time());
        session()->set('antispam_captcha_' . $formKey, (string) ($a + $b));

        return [
            'form_key'       => $formKey,
            'captcha_prompt' => $a . ' + ' . $b . ' =',
        ];
    }
}

if (! function_exists('form_antispam_validate')) {
    /**
     * @param array{check_content?: bool, email?: string, first_name?: string, last_name?: string, phone?: string, message?: string, subject?: string} $fields
     */
    function form_antispam_validate(IncomingRequest $request, string $formKey, array $fields = []): ?string
    {
        if (trim((string) $request->getPost('company_website')) !== '') {
            log_message('warning', 'Form spam blocked (honeypot): ' . $formKey);

            return 'Unable to submit the form. Please refresh the page and try again.';
        }

        $started = (int) session()->get('antispam_ts_' . $formKey);
        $elapsed = time() - $started;

        if ($started <= 0 || $elapsed < 3) {
            return 'Please wait a few seconds before submitting the form.';
        }

        if ($elapsed > 7200) {
            return 'This form has expired. Please refresh the page and try again.';
        }

        $expectedCaptcha = session()->get('antispam_captcha_' . $formKey);
        $givenCaptcha = trim((string) $request->getPost('antispam_captcha'));

        if ($expectedCaptcha === null || $givenCaptcha === '' || $givenCaptcha !== (string) $expectedCaptcha) {
            return 'Incorrect security answer. Please try again.';
        }

        session()->remove('antispam_captcha_' . $formKey);

        if ($rateError = form_antispam_rate_limit($request, $formKey)) {
            return $rateError;
        }

        if (! empty($fields['email']) && form_antispam_is_bad_email($fields['email'])) {
            log_message('warning', 'Form spam blocked (email): ' . $formKey . ' ' . $fields['email']);

            return 'Please enter a valid business email address.';
        }

        if (! empty($fields['check_content'])) {
            if ($contentError = form_antispam_validate_inquiry_content($fields)) {
                log_message('warning', 'Form spam blocked (content): ' . $formKey);

                return $contentError;
            }
        }

        return null;
    }
}

if (! function_exists('form_antispam_rate_limit')) {
    function form_antispam_rate_limit(IncomingRequest $request, string $formKey): ?string
    {
        $ip = $request->getIPAddress();
        $sessionKey = 'antispam_rate_' . $formKey . '_' . md5($ip);
        $windowStart = time() - 3600;
        $attempts = session()->get($sessionKey) ?? [];
        $attempts = array_values(array_filter($attempts, static fn ($ts) => (int) $ts >= $windowStart));

        if (count($attempts) >= 5) {
            return 'Too many submissions. Please try again after some time.';
        }

        return null;
    }
}

if (! function_exists('form_antispam_record_submit')) {
    function form_antispam_record_submit(IncomingRequest $request, string $formKey): void
    {
        $ip = $request->getIPAddress();
        $sessionKey = 'antispam_rate_' . $formKey . '_' . md5($ip);
        $attempts = session()->get($sessionKey) ?? [];
        $attempts[] = time();
        session()->set($sessionKey, $attempts);
    }
}

if (! function_exists('form_antispam_is_bad_email')) {
    function form_antispam_is_bad_email(string $email): bool
    {
        $email = strtolower(trim($email));

        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        if (preg_match('/\.(test|example|invalid|local)$/i', $email)) {
            return true;
        }

        if (preg_match('/^(test|admin|noreply|no-reply|fake|spam|bot)[0-9]*@/i', $email)) {
            return true;
        }

        $domain = substr(strrchr($email, '@') ?: '', 1);

        if ($domain === '') {
            return true;
        }

        $blockedDomains = [
            'mailinator.com', 'guerrillamail.com', 'guerrillamail.net', '10minutemail.com',
            'tempmail.com', 'yopmail.com', 'throwaway.email', 'sharklasers.com',
            'dispostable.com', 'getnada.com', 'maildrop.cc', 'trashmail.com',
        ];

        foreach ($blockedDomains as $blocked) {
            if ($domain === $blocked || str_ends_with($domain, '.' . $blocked)) {
                return true;
            }
        }

        return false;
    }
}

if (! function_exists('form_antispam_validate_inquiry_content')) {
    /**
     * @param array{first_name?: string, last_name?: string, phone?: string, message?: string, subject?: string} $fields
     */
    function form_antispam_validate_inquiry_content(array $fields): ?string
    {
        $firstName = trim((string) ($fields['first_name'] ?? ''));
        $lastName = trim((string) ($fields['last_name'] ?? ''));
        $phone = trim((string) ($fields['phone'] ?? ''));
        $message = trim((string) ($fields['message'] ?? ''));
        $subject = trim((string) ($fields['subject'] ?? ''));

        if (! form_antispam_valid_person_name($firstName) || ! form_antispam_valid_person_name($lastName)) {
            return 'Please enter a valid first and last name.';
        }

        if ($phone !== '' && ! form_antispam_valid_phone($phone)) {
            return 'Please enter a valid phone number.';
        }

        foreach ([$subject, $message] as $text) {
            if ($text === '') {
                continue;
            }

            if (form_antispam_contains_spam($text)) {
                return 'Your message could not be submitted. Please remove promotional or suspicious content.';
            }
        }

        if (strlen($message) > 5000 || strlen($subject) > 255) {
            return 'Message is too long.';
        }

        return null;
    }
}

if (! function_exists('form_antispam_valid_person_name')) {
    function form_antispam_valid_person_name(string $name): bool
    {
        $name = trim($name);

        if (strlen($name) < 2 || strlen($name) > 80) {
            return false;
        }

        if (preg_match('/https?:|www\.|<|>|@|\d{5,}/i', $name)) {
            return false;
        }

        return (bool) preg_match("/^[\p{L}\p{M}\s'.-]+$/u", $name);
    }
}

if (! function_exists('form_antispam_valid_phone')) {
    function form_antispam_valid_phone(string $phone): bool
    {
        $digits = preg_replace('/\D+/', '', $phone);

        return strlen((string) $digits) >= 7 && strlen((string) $digits) <= 15;
    }
}

if (! function_exists('form_antispam_contains_spam')) {
    function form_antispam_contains_spam(string $text): bool
    {
        $lower = strtolower($text);

        if (substr_count($lower, 'http://') + substr_count($lower, 'https://') + substr_count($lower, 'www.') >= 2) {
            return true;
        }

        $patterns = [
            'viagra', 'cialis', 'casino', 'lottery winner', 'bitcoin investment',
            'crypto investment', 'seo service', 'backlink', 'click here now',
            'work from home', 'make money fast', 'nigerian prince', 'wire transfer',
        ];

        foreach ($patterns as $pattern) {
            if (str_contains($lower, $pattern)) {
                return true;
            }
        }

        if (preg_match('/(.)\1{7,}/', $text)) {
            return true;
        }

        return false;
    }
}
