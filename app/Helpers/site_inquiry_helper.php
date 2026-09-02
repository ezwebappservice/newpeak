<?php

if (! function_exists('site_inquiry_notify_admin')) {
    function site_inquiry_notify_admin(array $setting, string $subject, string $html): void
    {
        $to = trim((string) ($setting['receive_email_to'] ?? ''));
        $from = trim((string) ($setting['send_email_from'] ?? ''));

        if ($to === '' || $from === '') {
            return;
        }

        try {
            $email = \Config\Services::email();
            $email->from($from);
            $email->to($to);
            $email->subject($subject);
            $email->setMailType('html');
            $email->setMessage($html);
            $email->send();
        } catch (\Throwable $e) {
            log_message('error', 'Inquiry admin notify failed: ' . $e->getMessage());
        }
    }
}

if (! function_exists('site_inquiry_save')) {
    function site_inquiry_save(string $source, array $fields): int
    {
        $model = new \App\Models\Model_site_inquiry();

        return $model->add([
            'form_source' => $source,
            'first_name'  => $fields['first_name'] ?? '',
            'last_name'   => $fields['last_name'] ?? '',
            'phone'       => $fields['phone'] ?? null,
            'email'       => $fields['email'] ?? '',
            'subject'     => $fields['subject'] ?? null,
            'message'     => $fields['message'] ?? '',
            'status'      => 'New',
            'created_at'  => date('Y-m-d H:i:s'),
        ]);
    }
}
