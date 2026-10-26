<?php

namespace App\Controllers;

use App\Libraries\RazorpayClient;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Contact extends MY_Controller
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper(['contact', 'news']);
        $this->Model_common = new \App\Models\Model_common();
        $this->Model_contact = new \App\Models\Model_contact();
    }

    public function index()
    {
        $pageContact = [];
        try {
            $pageContact = $this->Model_common->all_page_contact() ?: [];
        } catch (\Throwable $e) {
            log_message('debug', 'Contact CMS page unavailable: ' . $e->getMessage());
        }

        $this->render_frontend('view_contact', [
            'current_page'     => 'contact-us',
            'page_contact'     => $pageContact,
            'meta_title'       => $pageContact['mt_contact'] ?? 'Contact Us | Peak Potential Academy',
            'meta_description' => $pageContact['md_contact'] ?? 'Tell us a little about your goals, and our team will be in touch.',
            'meta_keywords'    => $pageContact['mk_contact'] ?? '',
        ]);
    }

    public function enquiry()
    {
        $this->render_frontend('view_enquiry', [
            'current_page'     => 'enquiry',
            'meta_title'       => 'Customer Enquiry | Peak Potential Academy',
            'meta_description' => 'Book a discovery call or demo with Peak Potential Academy. Tell us what you need and we will help you find the right next step.',
        ]);
    }

    public function thank_you()
    {
        $receipt = session()->getFlashdata('enquiry_receipt');

        $this->render_frontend('view_enquiry_thanks', [
            'current_page'     => 'enquiry-thanks',
            'meta_title'       => 'Thank You | Peak Potential Academy',
            'meta_description' => 'Your enquiry has been received. The Peak Potential Academy team will be in touch shortly.',
            'receipt'          => is_array($receipt) ? $receipt : null,
        ]);
    }

    public function connect()
    {
        return redirect()->to(contact_page_url());
    }

    public function send_email()
    {
        helper(['site_inquiry', 'form_antispam', 'form_ui']);
        $data['setting'] = $this->Model_common->all_setting();
        $redirectUrl = contact_page_url() . '#contact-form';

        if (! isset($_POST['form_contact'])) {
            return redirect()->to(contact_page_url());
        }

        if (PROJECT_MODE == 0) {
            return form_redirect_with_errors($redirectUrl, PROJECT_NOTIFICATION, 'connect_form_error');
        }

        $name = trim((string) $this->request->getPost('name', true));
        $firstName = trim((string) $this->request->getPost('first_name', true));
        $lastName = trim((string) $this->request->getPost('last_name', true));
        $email = trim((string) $this->request->getPost('email', true));
        $phone = trim((string) $this->request->getPost('phone', true));
        $interest = trim((string) $this->request->getPost('interest', true));
        $message = trim((string) $this->request->getPost('message', true));

        if ($firstName === '' && $name !== '') {
            $parts = preg_split('/\s+/', $name, 2) ?: [];
            $firstName = $parts[0] ?? '';
            $lastName = $parts[1] ?? $lastName;
        }

        $subject = $interest !== '' ? $interest : 'Contact Page Inquiry';

        if ($spamError = form_antispam_validate($this->request, 'contact_inquiry', [
            'check_content' => true,
            'email'         => $email,
            'first_name'    => $firstName,
            'last_name'     => $lastName,
            'phone'         => $phone,
            'message'       => $message,
            'subject'       => $subject,
        ])) {
            return form_redirect_with_errors($redirectUrl, $spamError, 'connect_form_error');
        }

        $errors = [];

        $usesSplitNameFields = $this->request->getPost('first_name') !== null
            || $this->request->getPost('last_name') !== null;

        if ($usesSplitNameFields) {
            if ($firstName === '') {
                $errors[] = 'First name is required.';
            }

            if ($lastName === '') {
                $errors[] = 'Last name is required.';
            }
        } elseif ($firstName === '' && $name === '') {
            $errors[] = 'Full name is required.';
        }

        if ($email === '') {
            $errors[] = 'Email address is required.';
        } elseif (! filter_var($email, FILTER_VALIDATE_EMAIL) || form_antispam_is_bad_email($email)) {
            $errors[] = 'Please enter a valid email address.';
        }

        if ($phone === '') {
            $errors[] = 'Phone number is required.';
        } elseif (! form_antispam_valid_phone($phone)) {
            $errors[] = 'Please enter a valid phone number.';
        }

        if ($message === '') {
            $errors[] = 'Message is required.';
        }

        if ($errors !== []) {
            return form_redirect_with_errors($redirectUrl, $errors, 'connect_form_error');
        }

        form_antispam_record_submit($this->request, 'contact_inquiry');

        $displayName = trim($firstName . ' ' . $lastName) ?: $name;

        try {
            site_inquiry_save('contact', [
                'first_name' => $firstName,
                'last_name'  => $lastName,
                'phone'      => $phone !== '' ? $phone : null,
                'email'      => $email,
                'subject'    => $subject,
                'message'    => $message,
                'form_data'  => [
                    'interest' => $interest,
                ],
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Contact enquiry save failed: ' . $e->getMessage());

            return form_redirect_with_errors($redirectUrl, 'We could not save your message. Please try again.', 'connect_form_error');
        }

        $msg = site_inquiry_email_html('Contact form – Peak Potential Academy', [
            'Full name'     => $displayName,
            'Email'         => $email,
            'Phone'         => $phone,
            'Interested in' => $interest !== '' ? $interest : 'Not selected',
            'Message'       => $message,
        ]);

        site_inquiry_notify_admin($data['setting'], 'Contact Form – ' . $displayName, $msg, $email, $displayName);

        return redirect()->to(base_url('enquiry/thank-you'));
    }

    public function send_discovery()
    {
        helper(['site_inquiry', 'form_antispam', 'form_ui']);
        $returnUrl = peak_enquiry_url() . '#enquiry-form';

        if (! isset($_POST['form_discovery'])) {
            return redirect()->to(peak_enquiry_url());
        }

        if (PROJECT_MODE == 0) {
            return form_redirect_with_errors($returnUrl, PROJECT_NOTIFICATION, 'discovery_form_error');
        }

        $firstName = trim((string) $this->request->getPost('first_name', true));
        $lastName = trim((string) $this->request->getPost('last_name', true));
        $email = trim((string) $this->request->getPost('email', true));
        $phone = trim((string) $this->request->getPost('phone', true));
        $country = trim((string) $this->request->getPost('country', true));
        $city = trim((string) $this->request->getPost('city', true));
        $applicant = trim((string) $this->request->getPost('applicant', true));
        $age = trim((string) $this->request->getPost('age', true));
        $program = trim((string) $this->request->getPost('program', true));
        $challengeFocus = trim((string) $this->request->getPost('challenge_focus', true));
        $otherChallenge = trim((string) $this->request->getPost('other_challenge', true));
        $meetingDate = trim((string) $this->request->getPost('meeting_date', true));
        $meetingTime = trim((string) $this->request->getPost('meeting_time', true));
        $paymentOption = trim((string) $this->request->getPost('payment_option', true));
        $payment = $this->enquiryPayments()[$paymentOption] ?? null;
        $challenges = $this->request->getPost('challenges') ?? [];
        if (! is_array($challenges)) {
            $challenges = [$challenges];
        }
        $challenges = array_values(array_filter(array_map('trim', $challenges)));

        $messageParts = [
            'Country: ' . $country,
            'City: ' . $city,
            'Applying as: ' . $applicant,
            'Age: ' . ($age !== '' ? $age : '—'),
            'Program: ' . $program,
            'Challenge focus: ' . ($challengeFocus !== '' ? $challengeFocus : '—'),
            'Challenges: ' . ($challenges !== [] ? implode(', ', $challenges) : '—'),
            'Other challenge: ' . ($otherChallenge !== '' ? $otherChallenge : '—'),
            'Preferred date: ' . $meetingDate,
            'Preferred time: ' . $meetingTime,
            'Payment: ' . ($payment['label'] ?? '—'),
        ];
        $message = implode("\n", $messageParts);

        if ($spamError = form_antispam_validate($this->request, 'discovery_inquiry', [
            'check_content' => true,
            'email'         => $email,
            'first_name'    => $firstName,
            'last_name'     => $lastName,
            'phone'         => $phone,
            'message'       => $message,
            'subject'       => $program,
        ])) {
            return form_redirect_with_errors($returnUrl, $spamError, 'discovery_form_error');
        }

        $errors = [];

        if ($firstName === '') {
            $errors[] = 'First name is required.';
        }
        if ($lastName === '') {
            $errors[] = 'Last name is required.';
        }
        if ($email === '') {
            $errors[] = 'Email address is required.';
        } elseif (! filter_var($email, FILTER_VALIDATE_EMAIL) || form_antispam_is_bad_email($email)) {
            $errors[] = 'Please enter a valid email address.';
        }
        if ($phone === '') {
            $errors[] = 'WhatsApp number is required.';
        } elseif (! form_antispam_valid_phone($phone)) {
            $errors[] = 'Please enter a valid phone number.';
        }
        if ($country === '') {
            $errors[] = 'Country is required.';
        }
        if ($city === '') {
            $errors[] = 'City is required.';
        }
        if ($applicant === '') {
            $errors[] = 'Please tell us who is applying.';
        }
        if ($program === '') {
            $errors[] = 'Please select a program.';
        }
        if ($meetingDate === '') {
            $errors[] = 'Please choose a meeting date.';
        }
        if ($meetingTime === '') {
            $errors[] = 'Please choose a time of day.';
        }
        if ($payment === null) {
            $errors[] = 'Please select a payment option.';
        }

        if ($errors !== []) {
            return form_redirect_with_errors($returnUrl, $errors, 'discovery_form_error');
        }

        $razorpay = new RazorpayClient();

        if (! $razorpay->isConfigured()) {
            return form_redirect_with_errors(
                $returnUrl,
                'Online payment is not set up yet. Please contact Peak Potential Academy.',
                'discovery_form_error'
            );
        }

        $displayName = trim($firstName . ' ' . $lastName);
        $token = bin2hex(random_bytes(16));
        $formData = [
            'country'         => $country,
            'city'            => $city,
            'applicant'       => $applicant,
            'age'             => $age,
            'program'         => $program,
            'challenge_focus' => $challengeFocus,
            'challenges'      => $challenges,
            'other_challenge' => $otherChallenge,
            'meeting_date'    => $meetingDate,
            'meeting_time'    => $meetingTime,
            'payment_option'  => $paymentOption,
            'payment_label'   => $payment['label'] . ' ' . $payment['amount_label'],
            'amount'          => $payment['amount_label'],
            'amount_paise'    => $payment['amount_paise'],
            'payment_status'  => 'pending',
            'public_token'    => $token,
        ];

        try {
            $inquiryId = site_inquiry_save('discovery', [
                'first_name' => $firstName,
                'last_name'  => $lastName,
                'phone'      => $phone,
                'email'      => $email,
                'subject'    => $program,
                'message'    => $message,
                'form_data'  => $formData,
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Discovery enquiry save failed: ' . $e->getMessage());

            return form_redirect_with_errors(
                $returnUrl,
                'We could not save your enquiry. Please try again.',
                'discovery_form_error'
            );
        }

        try {
            $order = $razorpay->createOrder($payment['amount_paise'], 'eq' . $inquiryId, [
                'enquiry' => (string) $inquiryId,
                'option'  => $payment['label'],
                'name'    => $displayName,
                'email'   => $email,
            ]);
        } catch (\Throwable $e) {
            $this->markEnquiryPayment($inquiryId, $formData, 'failed');
            log_message('error', 'Enquiry Razorpay order failed: ' . $e->getMessage());

            return form_redirect_with_errors($returnUrl, 'We could not start the payment. Please try again in a moment.', 'discovery_form_error');
        }

        $orderId = (string) ($order['id'] ?? '');

        if ($orderId === '') {
            $this->markEnquiryPayment($inquiryId, $formData, 'failed');

            return form_redirect_with_errors($returnUrl, 'We could not start the payment. Please try again in a moment.', 'discovery_form_error');
        }

        $formData['razorpay_order_id'] = $orderId;
        $this->markEnquiryPayment($inquiryId, $formData, 'pending');
        form_antispam_record_submit($this->request, 'discovery_inquiry');

        $this->render_frontend('view_enquiry_pay', [
            'current_page'      => 'enquiry',
            'meta_title'        => 'Complete Payment | Peak Potential Academy',
            'meta_description'  => 'Complete your Peak Potential Academy payment securely with Razorpay.',
            'enquiry'           => [
                'first_name'   => $firstName,
                'last_name'    => $lastName,
                'email'        => $email,
                'phone'        => $phone,
                'program'      => $program,
                'public_token' => $token,
                'amount_paise' => $payment['amount_paise'],
                'amount_label' => $payment['amount_label'],
                'payment_label'=> $payment['label'],
            ],
            'razorpay_key'      => $razorpay->keyId(),
            'razorpay_order'    => $orderId,
        ]);
    }

    public function verify_payment()
    {
        helper(['site_inquiry', 'form_ui']);
        $returnUrl = peak_enquiry_url() . '#enquiry-form';

        $token = trim((string) $this->request->getPost('public_token'));
        $paymentId = trim((string) $this->request->getPost('razorpay_payment_id'));
        $orderId = trim((string) $this->request->getPost('razorpay_order_id'));
        $signature = trim((string) $this->request->getPost('razorpay_signature'));

        $model = new \App\Models\Model_site_inquiry();
        $inquiry = $model->findDiscoveryByToken($token);

        if (! $inquiry) {
            return form_redirect_with_errors($returnUrl, 'We could not find this enquiry. Please submit the form again.', 'discovery_form_error');
        }

        $formData = $this->enquiryFormData($inquiry);

        if (($formData['payment_status'] ?? '') === 'paid') {
            return $this->redirectPaidEnquiry($inquiry, $formData);
        }

        $razorpay = new RazorpayClient();

        if (
            ($formData['razorpay_order_id'] ?? '') !== $orderId
            || ! $razorpay->verifySignature($orderId, $paymentId, $signature)
        ) {
            return form_redirect_with_errors($returnUrl, 'Payment could not be verified. If money was deducted, please contact us with your payment reference.', 'discovery_form_error');
        }

        $amountPaise = (int) ($formData['amount_paise'] ?? 0);

        try {
            $payment = $razorpay->fetchPayment($paymentId);
            $status = (string) ($payment['status'] ?? '');

            if ((string) ($payment['order_id'] ?? '') !== $orderId) {
                return form_redirect_with_errors($returnUrl, 'Payment does not match this enquiry.', 'discovery_form_error');
            }

            if ((int) ($payment['amount'] ?? 0) !== $amountPaise) {
                log_message('error', 'Enquiry payment amount mismatch for order ' . $orderId);

                return form_redirect_with_errors($returnUrl, 'Payment amount does not match the selected option. Please contact us with your payment reference.', 'discovery_form_error');
            }

            if ($status === 'authorized') {
                $payment = $razorpay->capturePayment($paymentId, $amountPaise);
                $status = (string) ($payment['status'] ?? $status);
            }

            if ($status !== 'captured') {
                return form_redirect_with_errors($returnUrl, 'Payment was not completed. Please try again.', 'discovery_form_error');
            }
        } catch (\Throwable $e) {
            log_message('error', 'Enquiry payment confirm failed: ' . $e->getMessage());

            return form_redirect_with_errors($returnUrl, 'We could not confirm the payment yet. Please contact us if the amount was deducted.', 'discovery_form_error');
        }

        $formData['payment_status'] = 'paid';
        $formData['payment_id'] = $paymentId;
        $model->updateById((int) $inquiry['id'], [
            'form_data' => json_encode($formData, JSON_UNESCAPED_UNICODE),
        ]);

        $this->notifyPaidEnquiry($inquiry, $formData);

        return $this->redirectPaidEnquiry($inquiry, $formData);
    }

    /**
     * @return array<string, array{label: string, amount_label: string, amount_paise: int}>
     */
    private function enquiryPayments(): array
    {
        return [
            'workshop' => [
                'label'        => 'Workshop',
                'amount_label' => '₹599',
                'amount_paise' => 59900,
            ],
            'bootcamp' => [
                'label'        => 'Boot Camp',
                'amount_label' => '₹5,999',
                'amount_paise' => 599900,
            ],
        ];
    }

    /**
     * @param array<string, mixed> $formData
     */
    private function markEnquiryPayment(int $inquiryId, array $formData, string $status): void
    {
        $formData['payment_status'] = $status;
        (new \App\Models\Model_site_inquiry())->updateById($inquiryId, [
            'form_data' => json_encode($formData, JSON_UNESCAPED_UNICODE),
        ]);
    }

    /**
     * @param array<string, mixed> $inquiry
     * @return array<string, mixed>
     */
    private function enquiryFormData(array $inquiry): array
    {
        $decoded = json_decode((string) ($inquiry['form_data'] ?? ''), true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * @param array<string, mixed> $inquiry
     * @param array<string, mixed> $formData
     */
    private function notifyPaidEnquiry(array $inquiry, array $formData): void
    {
        $setting = [];
        try {
            $setting = $this->Model_common->all_setting() ?: [];
        } catch (\Throwable $e) {
            log_message('debug', 'CMS settings unavailable: ' . $e->getMessage());
        }

        $displayName = trim(($inquiry['first_name'] ?? '') . ' ' . ($inquiry['last_name'] ?? ''));
        $challenges = $formData['challenges'] ?? [];
        if (! is_array($challenges)) {
            $challenges = [$challenges];
        }

        try {
            site_inquiry_notify_admin($setting, 'Discovery Enquiry – ' . $displayName, site_inquiry_email_html('Customer enquiry – Peak Potential Academy', [
                'Full name'       => $displayName,
                'Email'           => (string) ($inquiry['email'] ?? ''),
                'WhatsApp'        => (string) ($inquiry['phone'] ?? ''),
                'Country'         => (string) ($formData['country'] ?? ''),
                'City'            => (string) ($formData['city'] ?? ''),
                'Applying as'     => (string) ($formData['applicant'] ?? ''),
                'Age'             => (string) ($formData['age'] ?? ''),
                'Program'         => (string) ($formData['program'] ?? ''),
                'Challenge focus' => (string) ($formData['challenge_focus'] ?? ''),
                'Challenges'      => implode(', ', array_map('strval', $challenges)),
                'Other challenge' => (string) ($formData['other_challenge'] ?? ''),
                'Preferred date'  => (string) ($formData['meeting_date'] ?? ''),
                'Preferred time'  => (string) ($formData['meeting_time'] ?? ''),
                'Payment for'     => (string) ($formData['payment_label'] ?? ''),
                'Amount'          => (string) ($formData['amount'] ?? ''),
                'Payment ID'      => (string) ($formData['payment_id'] ?? ''),
            ]), (string) ($inquiry['email'] ?? ''), $displayName);
        } catch (\Throwable $e) {
            log_message('error', 'Discovery enquiry notify failed: ' . $e->getMessage());
        }
    }

    /**
     * @param array<string, mixed> $inquiry
     * @param array<string, mixed> $formData
     */
    private function redirectPaidEnquiry(array $inquiry, array $formData)
    {
        return redirect()->to(base_url('enquiry/thank-you'))->with('enquiry_receipt', [
            'name'    => trim(($inquiry['first_name'] ?? '') . ' ' . ($inquiry['last_name'] ?? '')),
            'payment' => (string) ($formData['payment_label'] ?? ''),
            'amount'  => (string) ($formData['amount'] ?? ''),
            'payment_id' => (string) ($formData['payment_id'] ?? ''),
        ]);
    }
}
