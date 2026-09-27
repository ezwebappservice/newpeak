<?php

if (! function_exists('site_email')) {
    function site_email(array $setting): \CodeIgniter\Email\Email
    {
        $port = (int) ($setting['smtp_port'] ?? 587);
        $crypto = 'tls';

        if ($port === 465) {
            $crypto = 'ssl';
        } elseif ($port === 25 || $port === 2525) {
            $crypto = '';
        }

        $email = \Config\Services::email();
        $email->initialize([
            'protocol'    => 'smtp',
            'SMTPHost'    => (string) ($setting['smtp_host'] ?? ''),
            'SMTPUser'    => (string) ($setting['smtp_username'] ?? ''),
            'SMTPPass'    => (string) ($setting['smtp_password'] ?? ''),
            'SMTPPort'    => $port,
            'SMTPCrypto'  => $crypto,
            'SMTPTimeout' => 20,
            'mailType'    => 'html',
            'charset'     => 'UTF-8',
            'newline'     => "\r\n",
            'CRLF'        => "\r\n",
        ]);

        return $email;
    }
}

if (! function_exists('site_inquiry_email_html')) {
    /**
     * @param array<string, string> $rows
     */
    function site_inquiry_email_html(string $title, array $rows): string
    {
        $html = '<h2 style="margin:0 0 16px;font-family:Georgia,serif;color:#560d17;">' . esc($title) . '</h2>';
        $html .= '<table cellpadding="8" cellspacing="0" style="border-collapse:collapse;width:100%;max-width:640px;font-family:Arial,sans-serif;font-size:14px;color:#352a2c;">';

        foreach ($rows as $label => $value) {
            $value = trim((string) $value);
            if ($value === '') {
                $value = '—';
            }

            $html .= '<tr>'
                . '<td style="width:180px;border:1px solid #eadfdb;background:#f9f1ee;font-weight:bold;vertical-align:top;">' . esc($label) . '</td>'
                . '<td style="border:1px solid #eadfdb;vertical-align:top;">' . nl2br(esc($value)) . '</td>'
                . '</tr>';
        }

        $html .= '</table>';

        return $html;
    }
}

if (! function_exists('site_inquiry_notify_admin')) {
    function site_inquiry_notify_admin(array $setting, string $subject, string $html, string $replyTo = '', string $replyName = ''): void
    {
        $to = trim((string) ($setting['receive_email_to'] ?? ''));
        $from = trim((string) ($setting['send_email_from'] ?? ''));

        if ($to === '' || $from === '') {
            return;
        }

        try {
            $email = site_email($setting);
            $email->setFrom($from, 'Peak Potential Academy');
            $email->setTo($to);
            // $email->setCC('info.hpsingh@gmail.com');
            if ($replyTo !== '' && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
                $email->setReplyTo($replyTo, $replyName);
            }
            $email->setSubject($subject);
            $email->setMailType('html');
            $email->setMessage($html);

            if (! $email->send()) {
                log_message('error', 'Inquiry admin notify failed: ' . $email->printDebugger(['headers']));
            }
        } catch (\Throwable $e) {
            log_message('error', 'Inquiry admin notify failed: ' . $e->getMessage());
        }
    }
}

if (! function_exists('site_inquiry_save')) {
    function site_inquiry_save(string $source, array $fields): int
    {
        $model = new \App\Models\Model_site_inquiry();
        $formData = $fields['form_data'] ?? null;

        if (is_array($formData)) {
            $formData = json_encode($formData, JSON_UNESCAPED_UNICODE);
        }

        return $model->add([
            'form_source' => $source,
            'first_name'  => $fields['first_name'] ?? '',
            'last_name'   => $fields['last_name'] ?? '',
            'phone'       => $fields['phone'] ?? null,
            'email'       => $fields['email'] ?? '',
            'subject'     => $fields['subject'] ?? null,
            'message'     => $fields['message'] ?? '',
            'form_data'   => $formData,
            'status'      => 'New',
            'created_at'  => date('Y-m-d H:i:s'),
        ]);
    }
}

if (! function_exists('site_inquiry_source_label')) {
    function site_inquiry_source_label(?string $source): string
    {
        return match ($source) {
            'discovery' => 'Customer Enquiry Form',
            'contact'   => 'Contact Page',
            'home'      => 'Home Page',
            'workshop'  => 'Workshop Registration',
            default     => $source !== null && $source !== '' ? ucfirst($source) : 'Unknown',
        };
    }
}

if (! function_exists('site_inquiry_form_data_rows')) {
    /**
     * @return list<array{label: string, value: string}>
     */
    function site_inquiry_form_data_rows(?string $json): array
    {
        if ($json === null || trim($json) === '') {
            return [];
        }

        $data = json_decode($json, true);

        if (! is_array($data) || $data === []) {
            return [];
        }

        $labels = [
            'name'             => 'Full name',
            'interest'         => 'Interest',
            'country'          => 'Country',
            'city'             => 'City',
            'applicant'        => 'Applying as',
            'age'              => 'Student/Attendee age',
            'program'          => 'Program',
            'challenge_focus'  => 'Challenge focus',
            'challenges'       => 'Challenges',
            'other_challenge'  => 'Other challenge',
            'meeting_date'     => 'Preferred date',
            'meeting_time'     => 'Preferred time',
            'medium'           => 'Medium of instruction',
            'topic'            => 'Topic request',
            'heard_from'       => 'Heard about workshop',
            'amount'           => 'Amount paid',
            'payment_id'       => 'Razorpay payment ID',
            'payment_status'   => 'Payment status',
        ];

        $rows = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = implode(', ', array_map('strval', $value));
            }

            $text = trim((string) $value);

            if ($text === '') {
                continue;
            }

            $rows[] = [
                'label' => $labels[$key] ?? ucfirst(str_replace('_', ' ', (string) $key)),
                'value' => $text,
            ];
        }

        return $rows;
    }
}
