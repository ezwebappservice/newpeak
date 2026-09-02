<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;



class Captcha extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_captcha = new \App\Models\Admin\Model_captcha();
    }

	public function setting()
	{
       	$data['setting'] = $this->Model_common->get_setting_data();
		$error = '';
		$success = '';

		if(isset($_POST['form1']))
		{

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

			$form_data = array(
				'captcha_contact'  => $_POST['captcha_contact'],
				'captcha_service_detail'=> $_POST['captcha_service_detail'],
				'captcha_portfolio_detail' => $_POST['captcha_portfolio_detail']
			);
			$this->Model_captcha->update($form_data);
		
			$success = 'Captcha Setting is updated successfully';
		    
			$this->session->setFlashdata('success',$success);
			redirect(base_url().'admin/captcha/setting');
           
		} else {
			$data['captcha'] = $this->Model_captcha->show();
	       	echo view('admin/view_header',$data);
			echo view('admin/view_captcha_setting',$data);
			echo view('admin/view_footer');
		}

	}

	public function index() {
		$data['setting'] = $this->Model_common->get_setting_data();
		$data['captcha'] = $this->Model_captcha->show_all();

		echo view('admin/view_header',$data);
		echo view('admin/view_captcha',$data);
		echo view('admin/view_footer');
	}

	public function add() {

		$data['setting'] = $this->Model_common->get_setting_data();
		$data['captcha'] = $this->Model_captcha->show_all();

		$error = '';
		$success = '';

		if(isset($_POST['form1'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

			$valid = 1;

			$captcha_value1 = $_POST['captcha_value1'];
			$captcha_value2 = $_POST['captcha_value2'];
			$captcha_result = $_POST['captcha_result'];
			$captcha_symbol = $_POST['captcha_symbol'];

			if($captcha_value1 == '')
			{
				$valid = 0;
				$error .= 'Value 1 can not be empty<br>';
			}
			if($captcha_value2 == '')
			{
				$valid = 0;
				$error .= 'Value 2 can not be empty<br>';
			}
			if($captcha_result == '')
			{
				$valid = 0;
				$error .= 'Result can not be empty<br>';
			}

	   		if($valid == 1)
		    {
		        $form_data = array(
					'captcha_value1' => $_POST['captcha_value1'],
					'captcha_value2' => $_POST['captcha_value2'],
					'captcha_result' => $_POST['captcha_result'],
					'captcha_symbol' => $_POST['captcha_symbol']
	            );
	            $this->Model_captcha->add($form_data);

		        $success = 'Captcha is added successfully!';
		        $this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/captcha');		        
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/captcha/add');
		    }
            
        } else {
            echo view('admin/view_header',$data);
			echo view('admin/view_captcha',$data);
			echo view('admin/view_footer');
        }
	}

	public function delete($id) {
    	$tot = $this->Model_captcha->captcha_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/captcha');
        	exit;
    	}

		if(PROJECT_MODE == 0) {
			$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
			redirect($_SERVER['HTTP_REFERER']);
		}

        $this->Model_captcha->delete($id);
        $success = 'Captcha is deleted successfully';
		$this->session->setFlashdata('success',$success);
		redirect(base_url().'admin/captcha');
	}

}