<?php

namespace App\Controllers;

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

        if ($firstName === '' && $name === '') {
            $errors[] = 'Full name is required.';
        }

        if ($email === '') {
            $errors[] = 'Email address is required.';
        } elseif (! filter_var($email, FILTER_VALIDATE_EMAIL) || form_antispam_is_bad_email($email)) {
            $errors[] = 'Please enter a valid email address.';
        }

        if ($phone !== '' && ! form_antispam_valid_phone($phone)) {
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

        $msg = '<html><head><title>Contact Form</title></head><body>'
            . '<h3>Contact Form – Peak Potential Academy</h3>'
            . '<b>Name: </b>' . esc($displayName) . '<br><br>'
            . '<b>Email: </b>' . esc($email) . '<br><br>'
            . ($phone !== '' ? '<b>Phone: </b>' . esc($phone) . '<br><br>' : '')
            . '<b>Interest: </b>' . esc($subject) . '<br><br>'
            . '<b>Message: </b>' . nl2br(esc($message))
            . '</body></html>';

        site_inquiry_notify_admin($data['setting'], 'Contact Form – ' . $displayName, $msg);

        $success = defined('SUCCESS_CONTACT_FORM') ? SUCCESS_CONTACT_FORM : 'Thank you for contacting us. We will get back to you shortly.';

        return form_redirect_with_success($redirectUrl, $success, 'connect_form_success');
    }

    public function send_discovery()
    {
        helper(['site_inquiry', 'form_antispam', 'form_ui']);
        $returnUrl = peak_enquiry_url() . '#enquiry-form';
        $setting = [];
        try {
            $setting = $this->Model_common->all_setting() ?: [];
        } catch (\Throwable $e) {
            log_message('debug', 'CMS settings unavailable: ' . $e->getMessage());
        }

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

        if ($errors !== []) {
            return form_redirect_with_errors($returnUrl, $errors, 'discovery_form_error');
        }

        form_antispam_record_submit($this->request, 'discovery_inquiry');

        $displayName = trim($firstName . ' ' . $lastName);

        try {
            site_inquiry_save('discovery', [
                'first_name' => $firstName,
                'last_name'  => $lastName,
                'phone'      => $phone,
                'email'      => $email,
                'subject'    => $program,
                'message'    => $message,
                'form_data'  => [
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
                ],
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
            site_inquiry_notify_admin($setting, 'Discovery Enquiry – ' . $displayName, '<html><head><title>Discovery Enquiry</title></head><body>'
                . '<h3>Customer Enquiry Form – Peak Potential Academy</h3>'
                . '<b>Name: </b>' . esc($displayName) . '<br><br>'
                . '<b>Email: </b>' . esc($email) . '<br><br>'
                . '<b>Phone: </b>' . esc($phone) . '<br><br>'
                . '<pre>' . esc($message) . '</pre>'
                . '</body></html>');
        } catch (\Throwable $e) {
            log_message('error', 'Discovery enquiry notify failed: ' . $e->getMessage());
        }

        return form_redirect_with_success(
            $returnUrl,
            'Thank you — your enquiry has been recorded. We’ll be in touch shortly.',
            'discovery_form_success'
        );
    }
}
