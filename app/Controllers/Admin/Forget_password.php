<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Forget_password extends BaseController 
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
    {
        parent::initController($request, $response, $logger);
        helper('security');
        $this->Model_forget_password = new \App\Models\Admin\Model_forget_password();
    }

    public function index()
    {
        $data['setting'] = $this->Model_forget_password->get_setting_data();

        if(isset($_POST['form1'])) {

            if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				safe_redirect_back(base_url('admin/forget-password'));
			}

            $email = trim((string) $this->request->getPost('email', true));

            $lock = sec_rate_limit_is_locked('admin_reset', $email, 3, 1800);

            if ($lock['locked']) {
                $this->session->setFlashdata('success', 'If that email is registered, a reset link has been sent.');
                redirect(base_url('admin/forget-password'));
            }

            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');

            if ($this->form_validation->run() == FALSE) {
                $this->session->setFlashdata('error', validation_errors());
				redirect(base_url('admin/forget-password'));
            }

            $user = $this->Model_forget_password->check_email($email);

            if ($user) {
                $token = admin_reset_token();

                $this->Model_forget_password->update($email, [
                    'token' => $token,
                ]);

                $resetUrl = base_url('admin/reset-password/index/' . (int) $user['id'] . '/' . $token);

                $msg = '<p>To reset your password, please <a href="' . esc($resetUrl) . '">click here</a> and enter a new password. This link expires in 1 hour.</p>';

                $config = [
					'protocol' => 'smtp',
					'smtp_host' => $data['setting']['smtp_host'],
					'smtp_port' => $data['setting']['smtp_port'],
					'smtp_user' => $data['setting']['smtp_username'],
					'smtp_pass' => $data['setting']['smtp_password'],
					'crlf' => "\r\n",
					'newline' => "\r\n",
					'mailtype'  => 'html',
					'charset'   => 'utf-8'
				];

				$this->email = \Config\Services::email();

                $this->email->from($data['setting']['send_email_from']);
                $this->email->to($email);
                $this->email->subject('Password Reset');
                $this->email->message($msg);
                $this->email->send();
            } else {
                sec_rate_limit_hit('admin_reset', $email, 3, 1800);
            }

            $this->session->setFlashdata('success', 'If that email is registered, a reset link has been sent.');
            redirect(base_url('admin/forget-password'));
        }

        echo view('admin/view_forget_password',$data);
    }
}
