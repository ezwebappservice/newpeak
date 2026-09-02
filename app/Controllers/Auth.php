<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Auth extends MY_Controller
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Model_common();
        $this->Model_customer = new \App\Models\Model_customer();
        $this->Model_portfolio = new \App\Models\Model_portfolio();
    }

    protected function commonData(): array
    {
        return [
            'setting'          => $this->Model_common->all_setting(),
            'page_home'        => $this->Model_common->all_page_home(),
            'comment'          => $this->Model_common->all_comment(),
            'social'           => $this->Model_common->all_social(),
            'all_news'         => $this->Model_common->all_news(),
            'portfolio_footer' => $this->Model_portfolio->get_portfolio_data(),
        ];
    }

    protected function redirectAfterLogin(): string
    {
        $redirect = $this->request->getPost('redirect')
            ?? $this->request->getGet('redirect')
            ?? session()->getFlashdata('auth_redirect');
        if ($redirect && str_starts_with($redirect, base_url())) {
            return $redirect;
        }
        if ($redirect && ! str_contains($redirect, '://')) {
            return base_url(ltrim($redirect, '/'));
        }

        return base_url('checkout');
    }

    protected function setCustomerSession(array $customer): void
    {
        session()->set([
            'shop_customer_id'    => $customer['customer_id'],
            'shop_customer_email' => $customer['email'],
            'shop_customer_name'  => trim($customer['first_name'] . ' ' . $customer['last_name']),
        ]);
    }

    public function login()
    {
        if (session()->get('shop_customer_id')) {
            return redirect()->to($this->redirectAfterLogin());
        }

        $data = $this->commonData();
        $data['redirect'] = $this->request->getGet('redirect') ?? 'checkout';

        if ($this->request->getMethod() === 'POST') {
            $email = trim((string) $this->request->getPost('email'));
            $password = (string) $this->request->getPost('password');

            if ($email === '' || $password === '') {
                $this->session->setFlashdata('error', 'Please enter your email and password.');
            } else {
                $customer = $this->Model_customer->verifyLogin($email, $password);
                if (! $customer) {
                    $this->session->setFlashdata('error', 'Invalid email or password.');
                } else {
                    $this->setCustomerSession($customer);
                    $this->session->setFlashdata('success', 'Welcome back, ' . esc($customer['first_name']) . '!');
                    return redirect()->to($this->redirectAfterLogin());
                }
            }
        }

        echo view('view_header', $data);
        echo view('view_auth_login', $data);
        echo view('view_footer', $data);
    }

    public function register()
    {
        if (session()->get('shop_customer_id')) {
            return redirect()->to($this->redirectAfterLogin());
        }

        $data = $this->commonData();
        $data['redirect'] = $this->request->getGet('redirect') ?? 'checkout';
        $data['old'] = [];

        if ($this->request->getMethod() === 'POST') {
            $data['old'] = [
                'first_name'    => trim((string) $this->request->getPost('first_name')),
                'last_name'     => trim((string) $this->request->getPost('last_name')),
                'email'         => trim((string) $this->request->getPost('email')),
                'phone'         => trim((string) $this->request->getPost('phone')),
                'address_line1' => trim((string) $this->request->getPost('address_line1')),
                'address_line2' => trim((string) $this->request->getPost('address_line2')),
                'city'          => trim((string) $this->request->getPost('city')),
                'state'         => trim((string) $this->request->getPost('state')),
                'postal_code'   => trim((string) $this->request->getPost('postal_code')),
                'country'       => trim((string) $this->request->getPost('country')),
            ];

            $password = (string) $this->request->getPost('password');
            $passwordConfirm = (string) $this->request->getPost('password_confirm');
            $errors = [];

            if ($data['old']['first_name'] === '') {
                $errors[] = 'First name is required.';
            }
            if ($data['old']['last_name'] === '') {
                $errors[] = 'Last name is required.';
            }
            if ($data['old']['email'] === '' || ! filter_var($data['old']['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'A valid email address is required.';
            } elseif ($this->Model_customer->emailExists($data['old']['email'])) {
                $errors[] = 'This email is already registered.';
            }
            if (strlen($password) < 6) {
                $errors[] = 'Password must be at least 6 characters.';
            }
            if ($password !== $passwordConfirm) {
                $errors[] = 'Passwords do not match.';
            }

            if ($errors === []) {
                $customerId = $this->Model_customer->create([
                    'email'         => $data['old']['email'],
                    'password'      => password_hash($password, PASSWORD_DEFAULT),
                    'first_name'    => $data['old']['first_name'],
                    'last_name'     => $data['old']['last_name'],
                    'phone'         => $data['old']['phone'],
                    'address_line1' => $data['old']['address_line1'],
                    'address_line2' => $data['old']['address_line2'],
                    'city'          => $data['old']['city'],
                    'state'         => $data['old']['state'],
                    'postal_code'   => $data['old']['postal_code'],
                    'country'       => $data['old']['country'] ?: 'United States',
                ]);

                $customer = $this->Model_customer->getById($customerId);
                $this->setCustomerSession($customer);
                $this->session->setFlashdata('success', 'Account created successfully!');
                return redirect()->to($this->redirectAfterLogin());
            }

            $this->session->setFlashdata('error', implode('<br>', $errors));
        }

        echo view('view_header', $data);
        echo view('view_auth_register', $data);
        echo view('view_footer', $data);
    }

    public function logout()
    {
        session()->remove(['shop_customer_id', 'shop_customer_email', 'shop_customer_name']);
        $this->session->setFlashdata('success', 'You have been logged out.');
        return redirect()->to(base_url('shop'));
    }
}
