<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Login extends BaseController 
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
    {
        parent::initController($request, $response, $logger);
        helper('security');
        $this->Model_login = new \App\Models\Admin\Model_login();
    }

    public function index()
    {
        $data['setting'] = $this->Model_login->get_setting_data();

        if ($this->session->get('logged_in')) {
            redirect(base_url().'admin/dashboard');
        }

        if(isset($_POST['form1'])) {

            $email = trim((string) $this->request->getPost('email', true));
            $password = (string) $this->request->getPost('password', true);

            $lock = sec_rate_limit_is_locked('admin_login', $email);

            if ($lock['locked']) {
                $minutes = max(1, (int) ceil($lock['retry_after'] / 60));
                $this->session->setFlashdata('error', 'Too many failed attempts. Try again in about ' . $minutes . ' minute(s).');
                redirect(base_url().'admin');
            }

            $user = $this->Model_login->check_email($email);
            $valid = $user && admin_verify_password($password, (string) ($user['password'] ?? ''));

            if (! $valid) {
                sec_rate_limit_hit('admin_login', $email);
                $this->session->setFlashdata('error', 'Invalid email or password.');
                redirect(base_url().'admin');
            }

            if (admin_password_needs_rehash((string) $user['password'])) {
                $this->Model_login->update_password_hash((int) $user['id'], admin_hash_password($password));
            }

            sec_rate_limit_clear('admin_login', $email);

            session()->regenerate(true);

            $this->session->set([
                'id'         => $user['id'],
                'email'      => $user['email'],
                'photo'      => $user['photo'],
                'role'       => $user['role'],
                'status'     => $user['status'],
                'logged_in'  => true,
            ]);

            redirect(base_url().'admin/dashboard');
        }

        echo view('admin/view_login', $data);
    }

    function logout() {
        $this->session->destroy();
        redirect(base_url().'admin');
    }
}
