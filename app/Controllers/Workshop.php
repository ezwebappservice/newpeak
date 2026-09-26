<?php

namespace App\Controllers;

use App\Libraries\RazorpayClient;
use Config\Workshop as WorkshopConfig;

class Workshop extends MY_Controller
{
    private WorkshopConfig $workshop;

    private \App\Models\Model_workshop_registration $registrations;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->workshop = config(WorkshopConfig::class);
        $this->registrations = new \App\Models\Model_workshop_registration();
    }

    public function index()
    {
        helper('form_ui');
        session()->set('workshop_form_seen', time());

        $this->render_frontend('view_workshop', $this->pageMeta([
            'workshop' => $this->workshop,
        ]));
    }

    public function checkout()
    {
        helper(['form_antispam', 'form_ui', 'site_inquiry']);
        $returnUrl = base_url('workshop-registration');

        if (! $this->request->is('post')) {
            return redirect()->to($returnUrl);
        }

        if (trim((string) $this->request->getPost('company_website')) !== '') {
            return form_redirect_with_errors($returnUrl, 'Unable to submit the form. Please refresh the page and try again.', 'workshop_form_error');
        }

        $seen = (int) session()->get('workshop_form_seen');
        if ($seen <= 0 || (time() - $seen) > 7200) {
            return form_redirect_with_errors($returnUrl, 'This form has expired. Please refresh the page and try again.', 'workshop_form_error');
        }

        $firstName = trim((string) $this->request->getPost('first_name'));
        $lastName = trim((string) $this->request->getPost('last_name'));
        $phone = trim((string) $this->request->getPost('phone'));
        $email = trim((string) $this->request->getPost('email'));
        $medium = trim((string) $this->request->getPost('medium'));
        $topic = trim((string) $this->request->getPost('topic'));
        $heardFrom = trim((string) $this->request->getPost('heard_from'));

        $errors = $this->validateRegistration($firstName, $lastName, $phone, $email, $medium, $topic, $heardFrom);

        if ($rateError = form_antispam_rate_limit($this->request, 'workshop_registration')) {
            $errors[] = $rateError;
        }

        if ($errors !== []) {
            return form_redirect_with_errors($returnUrl, $errors, 'workshop_form_error');
        }

        $razorpay = new RazorpayClient();

        if (! $razorpay->isConfigured()) {
            return form_redirect_with_errors(
                $returnUrl,
                'Online payment is not set up yet. Please contact Peak Potential Academy to reserve your seat.',
                'workshop_form_error'
            );
        }

        $token = bin2hex(random_bytes(16));
        $amountPaise = $this->workshop->amountPaise();

        try {
            $id = $this->registrations->add([
                'public_token'   => $token,
                'first_name'     => $firstName,
                'last_name'      => $lastName,
                'phone'          => $phone,
                'email'          => $email,
                'medium'         => $medium,
                'topic'          => $topic !== '' ? $topic : null,
                'heard_from'     => $heardFrom,
                'amount_paise'   => $amountPaise,
                'currency'       => 'INR',
                'payment_status' => 'pending',
                'created_at'     => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Workshop registration save failed: ' . $e->getMessage());

            return form_redirect_with_errors($returnUrl, 'We could not start your registration. Please try again.', 'workshop_form_error');
        }

        try {
            $order = $razorpay->createOrder($amountPaise, 'ws' . $id, [
                'registration' => (string) $id,
                'name'         => trim($firstName . ' ' . $lastName),
                'email'        => $email,
            ]);
        } catch (\Throwable $e) {
            $this->registrations->updateById($id, ['payment_status' => 'failed']);
            log_message('error', 'Workshop Razorpay order failed: ' . $e->getMessage());

            return form_redirect_with_errors($returnUrl, 'We could not start the payment. Please try again in a moment.', 'workshop_form_error');
        }

        $orderId = (string) ($order['id'] ?? '');

        if ($orderId === '') {
            $this->registrations->updateById($id, ['payment_status' => 'failed']);

            return form_redirect_with_errors($returnUrl, 'We could not start the payment. Please try again in a moment.', 'workshop_form_error');
        }

        $this->registrations->updateById($id, ['razorpay_order_id' => $orderId]);
        form_antispam_record_submit($this->request, 'workshop_registration');

        $registration = $this->registrations->findByToken($token);

        $this->render_frontend('view_workshop_pay', $this->pageMeta([
            'workshop'      => $this->workshop,
            'registration'  => $registration,
            'razorpay_key'  => $razorpay->keyId(),
            'razorpay_order'=> $orderId,
        ], 'Complete payment'));
    }

    public function verify()
    {
        helper(['site_inquiry', 'form_ui']);
        $returnUrl = base_url('workshop-registration');

        $token = trim((string) $this->request->getPost('public_token'));
        $paymentId = trim((string) $this->request->getPost('razorpay_payment_id'));
        $orderId = trim((string) $this->request->getPost('razorpay_order_id'));
        $signature = trim((string) $this->request->getPost('razorpay_signature'));

        $registration = $token !== '' ? $this->registrations->findByToken($token) : null;

        if (! $registration) {
            return form_redirect_with_errors($returnUrl, 'We could not find this registration. Please submit the form again.', 'workshop_form_error');
        }

        if (($registration['payment_status'] ?? '') === 'paid') {
            return $this->redirectPaid($registration);
        }

        $razorpay = new RazorpayClient();

        if (
            ($registration['razorpay_order_id'] ?? '') !== $orderId
            || ! $razorpay->verifySignature($orderId, $paymentId, $signature)
        ) {
            return $this->paymentFailed($registration, 'Payment could not be verified. If money was deducted, please contact us with your payment reference.');
        }

        try {
            $payment = $razorpay->fetchPayment($paymentId);
            $status = (string) ($payment['status'] ?? '');

            if ((string) ($payment['order_id'] ?? '') !== $orderId) {
                return $this->paymentFailed($registration, 'Payment does not match this registration.');
            }

            if ((int) ($payment['amount'] ?? 0) !== (int) $registration['amount_paise']) {
                log_message('error', 'Workshop payment amount mismatch for order ' . $orderId);

                return $this->paymentFailed($registration, 'Payment amount does not match the seat fee. Please contact us with your payment reference.', false);
            }

            if ($status === 'authorized') {
                $payment = $razorpay->capturePayment($paymentId, (int) $registration['amount_paise']);
                $status = (string) ($payment['status'] ?? $status);
            }

            if ($status !== 'captured') {
                return $this->paymentFailed($registration, 'Payment was not completed. Please try again.', false);
            }
        } catch (\Throwable $e) {
            log_message('error', 'Workshop payment confirm failed: ' . $e->getMessage());

            return $this->paymentFailed($registration, 'We could not confirm the payment yet. Please contact us if the amount was deducted.', false);
        }

        $paidAt = date('Y-m-d H:i:s');
        $this->registrations->updateById((int) $registration['id'], [
            'razorpay_payment_id' => $paymentId,
            'payment_status'      => 'paid',
            'paid_at'             => $paidAt,
        ]);

        $registration['razorpay_payment_id'] = $paymentId;
        $registration['payment_status'] = 'paid';
        $registration['paid_at'] = $paidAt;

        $this->recordInquiry($registration);
        $this->notify($registration);

        return $this->redirectPaid($registration);
    }

    public function thank_you()
    {
        $receipt = session()->getFlashdata('workshop_receipt');

        $this->render_frontend('view_workshop_thanks', $this->pageMeta([
            'workshop' => $this->workshop,
            'receipt'  => is_array($receipt) ? $receipt : null,
        ], 'Seat reserved'));
    }

    /**
     * @param array<string, mixed> $extra
     * @return array<string, mixed>
     */
    private function pageMeta(array $extra, string $titleSuffix = ''): array
    {
        $title = $titleSuffix !== ''
            ? $titleSuffix . ' | ' . $this->workshop->title
            : $this->workshop->title . ' | Workshop Registration';

        return array_merge([
            'current_page'     => 'workshop-registration',
            'meta_title'       => $title . ' | Peak Potential Academy',
            'meta_description' => 'Reserve your seat for Understand Your Teen, a live online workshop on 4th October 2026, 11:00 AM–12:00 PM IST.',
        ], $extra);
    }

    /**
     * @return list<string>
     */
    private function validateRegistration(
        string $firstName,
        string $lastName,
        string $phone,
        string $email,
        string $medium,
        string $topic,
        string $heardFrom
    ): array {
        helper('form_antispam');
        $errors = [];

        if (! form_antispam_valid_person_name($firstName)) {
            $errors[] = 'Please enter a valid first name.';
        }

        if (! form_antispam_valid_person_name($lastName)) {
            $errors[] = 'Please enter a valid last name.';
        }

        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL) || form_antispam_is_bad_email($email)) {
            $errors[] = 'Please enter a valid email address.';
        }

        if ($phone === '' || ! form_antispam_valid_phone($phone)) {
            $errors[] = 'Please enter a valid WhatsApp number.';
        }

        if (! in_array($medium, $this->workshop->mediums, true)) {
            $errors[] = 'Please choose a preferred medium of instruction.';
        }

        if (! in_array($heardFrom, $this->workshop->sources, true)) {
            $errors[] = 'Please tell us how you heard about this workshop.';
        }

        if (strlen($topic) > 1000) {
            $errors[] = 'The topic is too long.';
        } elseif ($topic !== '' && form_antispam_contains_spam($topic)) {
            $errors[] = 'Please rephrase the topic you would like us to include.';
        }

        return $errors;
    }

    /**
     * @param array<string, mixed> $registration
     */
    private function paymentFailed(array $registration, string $message, bool $markFailed = true)
    {
        if ($markFailed && ($registration['payment_status'] ?? '') === 'pending') {
            $this->registrations->updateById((int) $registration['id'], ['payment_status' => 'failed']);
        }

        return form_redirect_with_errors(base_url('workshop-registration'), $message, 'workshop_form_error');
    }

    /**
     * @param array<string, mixed> $registration
     */
    private function redirectPaid(array $registration)
    {
        return redirect()->to(base_url('workshop-registration/thank-you'))->with('workshop_receipt', [
            'name'       => trim(($registration['first_name'] ?? '') . ' ' . ($registration['last_name'] ?? '')),
            'email'      => (string) ($registration['email'] ?? ''),
            'phone'      => (string) ($registration['phone'] ?? ''),
            'medium'     => (string) ($registration['medium'] ?? ''),
            'payment_id' => (string) ($registration['razorpay_payment_id'] ?? ''),
            'amount'     => '₹' . number_format(((int) ($registration['amount_paise'] ?? 0)) / 100),
        ]);
    }

    /**
     * @param array<string, mixed> $registration
     */
    private function recordInquiry(array $registration): void
    {
        if (! empty($registration['inquiry_id'])) {
            return;
        }

        try {
            $inquiryId = site_inquiry_save('workshop', [
                'first_name' => (string) $registration['first_name'],
                'last_name'  => (string) $registration['last_name'],
                'phone'      => (string) $registration['phone'],
                'email'      => (string) $registration['email'],
                'subject'    => $this->workshop->title,
                'message'    => 'Paid workshop registration. Payment ' . ($registration['razorpay_payment_id'] ?? ''),
                'form_data'  => [
                    'medium'       => (string) ($registration['medium'] ?? ''),
                    'topic'        => (string) ($registration['topic'] ?? ''),
                    'heard_from'   => (string) ($registration['heard_from'] ?? ''),
                    'amount'       => '₹' . number_format(((int) ($registration['amount_paise'] ?? 0)) / 100),
                    'payment_id'   => (string) ($registration['razorpay_payment_id'] ?? ''),
                    'payment_status' => 'Paid',
                ],
            ]);

            $this->registrations->updateById((int) $registration['id'], ['inquiry_id' => $inquiryId]);
        } catch (\Throwable $e) {
            log_message('error', 'Workshop inquiry save failed: ' . $e->getMessage());
        }
    }

    /**
     * @param array<string, mixed> $registration
     */
    private function notify(array $registration): void
    {
        $name = trim(($registration['first_name'] ?? '') . ' ' . ($registration['last_name'] ?? ''));
        $email = (string) ($registration['email'] ?? '');
        $amount = '₹' . number_format(((int) ($registration['amount_paise'] ?? 0)) / 100);
        $rows = [
            'Workshop'      => $this->workshop->title,
            'When'          => $this->workshop->when,
            'Where'         => $this->workshop->where,
            'Full name'     => $name,
            'Email'         => $email,
            'WhatsApp'      => (string) ($registration['phone'] ?? ''),
            'Medium'        => (string) ($registration['medium'] ?? ''),
            'Topic request' => (string) ($registration['topic'] ?? ''),
            'Heard from'    => (string) ($registration['heard_from'] ?? ''),
            'Amount'        => $amount,
            'Payment ID'    => (string) ($registration['razorpay_payment_id'] ?? ''),
        ];

        try {
            $setting = [];
            if (! isset($this->Model_common)) {
                $this->Model_common = new \App\Models\Model_common();
            }
            $setting = $this->Model_common->all_setting() ?: [];
            site_inquiry_notify_admin(
                $setting,
                'Workshop seat paid – ' . $name,
                site_inquiry_email_html('Workshop registration – ' . $this->workshop->title, $rows),
                $email,
                $name
            );
            $this->emailRegistrant($setting, $registration);
        } catch (\Throwable $e) {
            log_message('error', 'Workshop notify failed: ' . $e->getMessage());
        }
    }

    /**
     * @param array<string, mixed> $setting
     * @param array<string, mixed> $registration
     */
    private function emailRegistrant(array $setting, array $registration): void
    {
        $to = trim((string) ($registration['email'] ?? ''));
        $from = trim((string) ($setting['send_email_from'] ?? ''));

        if ($to === '' || $from === '' || ! filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return;
        }

        $email = site_email($setting);
        $email->setFrom($from, 'Sapna KS');
        $email->setTo($to);
        $email->setSubject('You’re Registered! Welcome to Parenting Unplugged 🌸');
        $email->setMailType('html');
        $email->setMessage($this->registrationEmailHtml(trim((string) ($registration['first_name'] ?? ''))));

        if (! $email->send()) {
            log_message('error', 'Workshop registrant email failed: ' . $email->printDebugger(['headers']));
        }
    }

    private function registrationEmailHtml(string $parentName): string
    {
        $p = 'margin:0 0 16px;font-family:Arial,sans-serif;font-size:16px;line-height:1.6;color:#352a2c;';

        $greeting = $parentName !== '' ? 'Dear Parent ' . esc($parentName) . ',' : 'Dear Parent,';

        $html = '<div style="max-width:640px;">';
        $html .= '<p style="' . $p . '">' . $greeting . '</p>';
        $html .= '<p style="' . $p . '">Thank you for registering for <strong>Parenting Unplugged</strong>.</p>';
        $html .= '<p style="' . $p . '">I’m looking forward to spending this hour with you and helping you navigate the teenage years with more understanding, confidence and calm.</p>';
        $html .= '<p style="' . $p . '"><strong>Workshop Details:</strong><br>Date: 4th October 2026<br>Time: 11:00 AM – 12:00 PM IST<br>Mode: Live on Zoom</p>';
        $html .= '<p style="' . $p . '">Your Zoom joining link will be shared with you in a separate email 24 hours before the workshop. Please keep an eye on your registered email inbox.</p>';
        $html .= '<p style="' . $p . '">During the workshop, we’ll work around three practical areas:<br><strong>Emotional Strength | Healthier Boundaries | Better Conversations</strong></p>';
        $html .= '<p style="' . $p . '">I’ll also use the responses shared during registration to make the session relevant to the real challenges parents are facing.</p>';
        $html .= '<p style="' . $p . '"><strong>Before the workshop:</strong><br>This is an interactive, activity-based session, so please ensure you have:</p>';
        $html .= '<p style="' . $p . '">✅ Notebook and pen — mandatory<br>✅ Stable internet connection<br>✅ A device with working audio and video<br>✅ Camera and microphone enabled during the session</p>';
        $html .= '<p style="' . $p . '">Please plan to join 5 minutes before the scheduled start time.</p>';
        $html .= '<p style="' . $p . '">Come ready to participate, reflect and take away practical tools that you can start using with your teenager.</p>';
        $html .= '<p style="' . $p . '">Looking forward to having you with us.</p>';
        $html .= '<p style="' . $p . 'margin-bottom:0;">Warmly,<br>Sapna KS<br><a href="tel:+919999689932" style="color:#6b1d2a;text-decoration:none;">+919999689932</a></p>';
        $html .= '</div>';

        return $html;
    }
}
