<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Newsletter extends MY_Controller
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Model_common();
        $this->Model_newsletter = new \App\Models\Model_newsletter();
    }

    public function send()
    {
        helper(['form_antispam', 'form_ui']);
        $data['setting'] = $this->Model_common->all_setting();
        $redirectUrl = previous_url() ?: base_url();

        if (! isset($_POST['form_subscribe'])) {
            return redirect()->to($redirectUrl);
        }

        if (PROJECT_MODE == 0) {
            return form_redirect_with_errors($redirectUrl . '#newsletterForm', PROJECT_NOTIFICATION, 'newsletter_form_error');
        }

        $email = trim((string) $this->request->getPost('email_subscribe', true));

        if ($spamError = form_antispam_validate($this->request, 'newsletter', ['email' => $email])) {
            return form_redirect_with_errors($redirectUrl . '#newsletterForm', $spamError, 'newsletter_form_error');
        }

        $errors = [];

        if ($email === '') {
            $errors[] = 'Email address is required.';
        } elseif (! filter_var($email, FILTER_VALIDATE_EMAIL) || form_antispam_is_bad_email($email)) {
            $errors[] = 'Please enter a valid email address.';
        } elseif ($this->Model_newsletter->total_subscriber_by_email($email)) {
            $errors[] = defined('ERROR_EXIST_EMAIL') ? ERROR_EXIST_EMAIL : 'This email is already subscribed.';
        }

        if ($errors !== []) {
            return form_redirect_with_errors($redirectUrl . '#newsletterForm', $errors, 'newsletter_form_error');
        }

        form_antispam_record_submit($this->request, 'newsletter');

        $now = date('Y-m-d H:i:s');
        $this->Model_newsletter->add([
            'subs_email'     => $email,
            'subs_date'      => date('Y-m-d'),
            'subs_date_time' => $now,
            'subs_hash'      => '',
            'subs_active'    => 1,
        ]);

        $this->tryNotifyAdmin($data['setting'], 'New Newsletter Subscription', '
            <p>A new newsletter subscription was received from the website.</p>
            <p><strong>Email:</strong> ' . esc($email) . '</p>
            <p><strong>Date:</strong> ' . esc($now) . '</p>
        ');

        $success = defined('SUCCESS_SUBSCRIPTION_FORM')
            ? SUCCESS_SUBSCRIPTION_FORM
            : 'Thank you for subscribing to our newsletter.';

        return form_redirect_with_success($redirectUrl . '#newsletterForm', $success, 'newsletter_form_success');
    }

    /**
     * Legacy double-opt-in URL — auto-activates if a pending row still exists.
     */
    public function verify($email = 0, $hash = 0)
    {
        if (! $email || ! $hash) {
            return redirect()->to(base_url());
        }

        if ($this->Model_newsletter->check_url($email, $hash)) {
            $this->Model_newsletter->update($email, $hash, [
                'subs_hash'   => '',
                'subs_active' => 1,
            ]);
        }

        $data = [
            'setting'   => $this->Model_common->all_setting(),
            'page_home' => $this->Model_common->all_page_home(),
            'comment'   => $this->Model_common->all_comment(),
            'social'    => $this->Model_common->all_social(),
            'all_news'  => $this->Model_common->all_news(),
        ];

        echo view('view_header', $data);
        echo view('view_thankyou_subscribe', $data);
        echo view('view_footer', $data);
    }

    private function tryNotifyAdmin(array $setting, string $subject, string $html): void
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
            log_message('error', 'Newsletter admin notify failed: ' . $e->getMessage());
        }
    }
}
