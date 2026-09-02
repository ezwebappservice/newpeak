<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Profile extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_profile = new \App\Models\Admin\Model_profile();
    }
	public function index()
	{
		$data['setting'] = $this->Model_common->get_setting_data();

		echo view('admin/view_header',$data);
		echo view('admin/view_profile',$data);
		echo view('admin/view_footer');
		
	}
	public function update()
	{
		$error = '';
		$success = '';

		$data['setting'] = $this->Model_common->get_setting_data();

		if(isset($_POST['form1'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				safe_redirect_back(base_url('admin/profile'));
			}

			$valid = 1;

			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error = validation_errors();
            }

            if($valid == 1) {
	            $form_data = array(
					'email'     => $_POST['email']
	            );
	        	$this->Model_profile->update($form_data);
	        	$success = 'Profile Information is updated successfully!';
	        	
	        	$this->session->set($form_data);

	        	$this->session->setFlashdata('success',$success);
	        	redirect(base_url().'admin/profile');
            }
            else {
            	$this->session->setFlashdata('error',$error);
	        	redirect(base_url().'admin/profile');
            }
		}

		if(isset($_POST['form2'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				safe_redirect_back(base_url('admin/profile'));
			}

			$valid = 1;
			$error = '';
			$path = $_FILES['photo']['name'];
		    $path_tmp = $_FILES['photo']['tmp_name'];
		    if($path!='') {
		        $imageCheck = validate_uploaded_image($path_tmp, $path);
		        if($imageCheck['ok'] == FALSE) {
		            $valid = 0;
		            $error = ($imageCheck['error'] ?: 'You must upload a jpg, jpeg, gif or png file') . '<br>';
		        }
		    } else {
		    	$valid = 0;
		        $error = 'You must have to select a photo<br>';
		    }
		    if($valid == 1) {
		    	safe_unlink_upload($this->session->get('photo'));

		    	$ext = $imageCheck['ext'];
		    	$final_name = 'user-' . (int) $this->session->get('id') . '-' . bin2hex(random_bytes(8)) . '.' . $ext;
		        if (! move_uploaded_to_uploads($path_tmp, $final_name)) {
		        	$this->session->setFlashdata('error', 'Unable to save uploaded photo.');
		        	redirect(base_url().'admin/profile');
		        }
		    			        
				$form_data = array(
					'photo' => $final_name
	            );
	        	$this->Model_profile->update($form_data);
	        	$success = 'Photo is updated successfully!';

	        	$this->session->set($form_data);
	        	$this->session->setFlashdata('success',$success);
	        	redirect(base_url().'admin/profile');
		    }
		    else {
		    	$this->session->setFlashdata('error',$error);
	        	redirect(base_url().'admin/profile');
		    }
		}

		if(isset($_POST['form3'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				safe_redirect_back(base_url('admin/profile'));
			}
			
			$valid = 1;

		    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		    $this->form_validation->set_rules('re_password', 'Retype Password', 'trim|required|matches[password]');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error = validation_errors();
            }

		    if($valid == 1) {

		    	$form_data = array(
					'password' => admin_hash_password((string) $_POST['password'])
	            );
	        	$this->Model_profile->update($form_data);
	        	$success = 'Password is updated successfully!';
	        	
	        	$this->session->setFlashdata('success',$success);
	        	redirect(base_url().'admin/profile');
		    }
		    else {
		    	$this->session->setFlashdata('error',$error);
	        	redirect(base_url().'admin/profile');
		    }
		}

		$data['setting'] = $this->Model_common->get_setting_data();

		echo view('admin/view_header',$data);
		echo view('admin/view_profile',$data);
		echo view('admin/view_footer');
	}
	
}
