<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Client extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_client = new \App\Models\Admin\Model_client();
    }

	public function index()
	{
		$data['setting'] = $this->Model_common->get_setting_data();

		$data['client'] = $this->Model_client->show();

		echo view('admin/view_header',$data);
		echo view('admin/view_client',$data);
		echo view('admin/view_footer');
	}

	public function add()
	{
		$data['setting'] = $this->Model_common->get_setting_data();

		$error = '';
		$success = '';

		if(isset($_POST['form1'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

			$valid = 1;

			$this->form_validation->set_rules('name', 'Name', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

            $path = $_FILES['photo']['name'];
		    $path_tmp = $_FILES['photo']['tmp_name'];

		    if($path!='') {
		        $ext = pathinfo( $path, PATHINFO_EXTENSION );
		        $file_name = basename( $path, '.' . $ext );
		        $ext_check = $this->Model_common->extension_check_photo($ext);
		        if($ext_check == FALSE) {
		            $valid = 0;
		            $error .= 'You must have to upload jpg, jpeg, gif or png file for featured photo<br>';
		        }
		    } else {
		    	$valid = 0;
		        $error .= 'You must have to select a photo for featured photo<br>';
		    }

		    if($valid == 1) 
		    {
				$next_id = $this->Model_client->get_auto_increment_id();
				foreach ($next_id as $row) {
		            $ai_id = $row['Auto_increment'];
		        }

		        $final_name = 'client-'.$ai_id.'.'.$ext;
		        move_uploaded_to_uploads($path_tmp, $final_name);

		        $form_data = array(
					'name'  => $_POST['name'],
					'url'   => $_POST['url'],
					'photo' => $final_name
	            );
	            $this->Model_client->add($form_data);

		        $success = 'Client is added successfully!';
		        $this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/client');
		    } 
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/client/add');
		    }
            
        } else {
            
            echo view('admin/view_header',$data);
			echo view('admin/view_client_add',$data);
			echo view('admin/view_footer');
        }
		
	}


	public function edit($id)
	{
		
    	// If there is no client in this id, then redirect
    	$tot = $this->Model_client->client_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/client');
        	exit;
    	}
       	
       	$data['setting'] = $this->Model_common->get_setting_data();
		$error = '';
		$success = '';


		if(isset($_POST['form1'])) 
		{

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

			$valid = 1;

			$this->form_validation->set_rules('name', 'Name', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

            $path = $_FILES['photo']['name'];
		    $path_tmp = $_FILES['photo']['tmp_name'];

		    if($path!='') {
		        $ext = pathinfo( $path, PATHINFO_EXTENSION );
		        $file_name = basename( $path, '.' . $ext );
		        $ext_check = $this->Model_common->extension_check_photo($ext);
		        if($ext_check == FALSE) {
		            $valid = 0;
		            $error .= 'You must have to upload jpg, jpeg, gif or png file for featured photo<br>';
		        }
		    }

		    if($valid == 1) 
		    {
		    	$data['client'] = $this->Model_client->get_client($id);

		    	if($path == '') {
		    		$form_data = array(
						'name' => $_POST['name'],
						'url'  => $_POST['url']
		            );
		            $this->Model_client->update($id,$form_data);
				}
				else {
					safe_unlink_upload($data['client']['photo']);

					$final_name = 'client-'.$id.'.'.$ext;
		        	move_uploaded_to_uploads($path_tmp, $final_name);

		        	$form_data = array(
						'name'  => $_POST['name'],
						'url'   => $_POST['url'],
						'photo' => $final_name
		            );
		            $this->Model_client->update($id,$form_data);
				}
				
				$success = 'Client is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/client');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/client/edit'.$id);
		    }
           
		} else {
			$data['client'] = $this->Model_client->get_client($id);
	       	echo view('admin/view_header',$data);
			echo view('admin/view_client_edit',$data);
			echo view('admin/view_footer');
		}

	}


	public function delete($id) 
	{
		// If there is no client in this id, then redirect
    	$tot = $this->Model_client->client_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/client');
        	exit;
    	}

		if(PROJECT_MODE == 0) {
			$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
			redirect($_SERVER['HTTP_REFERER']);
		}

        $data['client'] = $this->Model_client->get_client($id);
        if($data['client']) {
            safe_unlink_upload($data['client']['photo']);
        }

        $this->Model_client->delete($id);
        $success = 'Client is deleted successfully';
		$this->session->setFlashdata('success',$success);
        redirect(base_url().'admin/client');
    }

}