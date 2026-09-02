<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Reset_password extends BaseController 
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
    {
        parent::initController($request, $response, $logger);
        helper('security');
        $this->Model_reset_password = new \App\Models\Admin\Model_reset_password();
    }

    public function index($userId = 0, $token = '')
    {
        $user = $this->Model_reset_password->check_url($userId, $token);

        if(!$user) {
            $this->session->setFlashdata('error', 'This reset link is invalid or has expired.');
            redirect(base_url().'admin');
            exit;
        }

        $data['setting'] = $this->Model_reset_password->get_setting_data();
        
        if(isset($_POST['form1'])) {

            if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				safe_redirect_back(base_url('admin'));
			}
            
            $valid = 1;
            $error = '';

            $this->form_validation->set_rules('new_password', 'Password', 'trim|required|min_length[8]');
            $this->form_validation->set_rules('re_password', 'Retype Password', 'trim|required|matches[new_password]');

            if($this->form_validation->run() == FALSE) {
                $valid = 0;
                $error = validation_errors();
            }

            if($valid == 1) 
            {
                $this->Model_reset_password->update((int) $userId, [
                    'password' => admin_hash_password((string) $_POST['new_password']),
                    'token'    => '',
                ]);
                $this->session->setFlashdata('success', 'Password is updated successfully!');
                redirect(base_url().'admin/reset-password/success');
            }
            else
            {
                $this->session->setFlashdata('error',$error);
                $data['var1'] = $userId;
                $data['var2'] = $token;
                echo view('admin/view_reset_password',$data);
            }
        } else {
            $data['var1'] = $userId;
            $data['var2'] = $token;
            echo view('admin/view_reset_password',$data);
        }        
    }

    public function success() 
    {
        $data['setting'] = $this->Model_reset_password->get_setting_data();
        echo view('admin/view_reset_password_success',$data);
    }
}
