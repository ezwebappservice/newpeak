<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Service extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_service = new \App\Models\Admin\Model_service();
    }

	public function index()
	{
		$data['setting'] = $this->Model_common->get_setting_data();

		$data['service'] = $this->Model_service->show();

		echo view('admin/view_header',$data);
		echo view('admin/view_service',$data);
		echo view('admin/view_footer');
	}

	public function add()
	{
		$data['setting'] = $this->Model_common->get_setting_data();
		$data['all_lang'] = $this->Model_common->all_lang();

		$error = '';
		$success = '';

		if(isset($_POST['form1'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}


			$valid = 1;

			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('short_description', 'Short Description', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

            $path = $_FILES['photo']['name'];
		    $path_tmp = $_FILES['photo']['tmp_name'];
		    $final_name = '';

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
		    	if($path != '') {
		    		$next_id = $this->Model_service->get_auto_increment_id();
		    		foreach ($next_id as $row) {
			            $ai_id = $row['Auto_increment'];
			        }
			        $final_name = 'service-'.$ai_id.'.'.$ext;
			        move_uploaded_to_uploads($path_tmp, $final_name);
		    	}

		        $form_data = array(
					'name'              => $_POST['name'],
					'short_description' => $_POST['short_description'],
					'description'       => $_POST['description'],
					'photo'             => $final_name,
					'meta_title'        => $_POST['meta_title'],
					'meta_keyword'      => $_POST['meta_keyword'],
					'meta_description'  => $_POST['meta_description'],
					'icon'              => $_POST['icon'] ?? '',
					'link_url'          => $_POST['link_url'] ?? '',
					'link_text'         => $_POST['link_text'] ?? '',
					'lang_id'           => $_POST['lang_id']
	            );
	            $this->Model_service->add($form_data);

		        $success = 'Service is added successfully!';
		        $this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/service');
		    } 
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/service/add');
		    }
            
        } else {
            
            echo view('admin/view_header',$data);
			echo view('admin/view_service_add',$data);
			echo view('admin/view_footer');
        }
		
	}


	public function edit($id)
	{
		
    	// If there is no service in this id, then redirect
    	$tot = $this->Model_service->service_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/service');
        	exit;
    	}
       	
       	$data['setting'] = $this->Model_common->get_setting_data();
       	$data['all_lang'] = $this->Model_common->all_lang();
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
			$this->form_validation->set_rules('short_description', 'Short Description', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'trim|required');

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
		    	$data['service'] = $this->Model_service->getData($id);

		    	if($path == '') {
		    		$form_data = array(
						'name'              => $_POST['name'],
						'short_description' => $_POST['short_description'],
						'description'       => $_POST['description'],
						'meta_title'        => $_POST['meta_title'],
						'meta_keyword'      => $_POST['meta_keyword'],
						'meta_description'  => $_POST['meta_description'],
						'icon'              => $_POST['icon'] ?? '',
						'link_url'          => $_POST['link_url'] ?? '',
						'link_text'         => $_POST['link_text'] ?? '',
						'lang_id'           => $_POST['lang_id']
		            );
		            $this->Model_service->update($id,$form_data);
				}
				else {
					safe_unlink_upload($data['service']['photo']);

					$final_name = 'service-'.$id.'.'.$ext;
		        	move_uploaded_to_uploads($path_tmp, $final_name);

		        	$form_data = array(
						'name'              => $_POST['name'],
						'short_description' => $_POST['short_description'],
						'description'       => $_POST['description'],
						'photo'             => $final_name,
						'meta_title'        => $_POST['meta_title'],
						'meta_keyword'      => $_POST['meta_keyword'],
						'meta_description'  => $_POST['meta_description'],
						'icon'              => $_POST['icon'] ?? '',
						'link_url'          => $_POST['link_url'] ?? '',
						'link_text'         => $_POST['link_text'] ?? '',
						'lang_id'           => $_POST['lang_id']
		            );
		            $this->Model_service->update($id,$form_data);
				}
				$success = 'Service is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/service');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/service/edit/'.$id);
		    }
           
		} else {
			$data['service'] = $this->Model_service->getData($id);
	       	echo view('admin/view_header',$data);
			echo view('admin/view_service_edit',$data);
			echo view('admin/view_footer');
		}

	}


	public function delete($id) 
	{
		// If there is no service in this id, then redirect
    	$tot = $this->Model_service->service_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/service');
        	exit;
    	}

		if(PROJECT_MODE == 0) {
			$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
			redirect($_SERVER['HTTP_REFERER']);
		}

        $data['service'] = $this->Model_service->getData($id);
        if($data['service']) {
            safe_unlink_upload($data['service']['photo']);
        }

        $this->Model_service->delete($id);
        $success = 'Service is deleted successfully';
        $this->session->setFlashdata('success',$success);
        redirect(base_url().'admin/service');
    }

}