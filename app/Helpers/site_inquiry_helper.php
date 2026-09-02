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
