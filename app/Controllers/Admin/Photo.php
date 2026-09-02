<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;



class Photo extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_photo = new \App\Models\Admin\Model_photo();
    }

	public function index()
	{
		$data['setting'] = $this->Model_common->get_setting_data();

		$data['photo'] = $this->Model_photo->show();

		echo view('admin/view_header',$data);
		echo view('admin/view_photo',$data);
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
				$next_id = $this->Model_photo->get_auto_increment_id();
				foreach ($next_id as $row) {
		            $ai_id = $row['Auto_increment'];
		        }

		        $final_name = 'photo-'.$ai_id.'.'.$ext;
		        move_uploaded_to_uploads($path_tmp, $final_name);

		        $form_data = array(
					'photo_name' => $final_name
	            );
	            $this->Model_photo->add($form_data);

		        $success = 'Photo is added successfully!';
		        $this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/photo');

		    } 
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/photo/add');
		    }
            
        } else {            
            echo view('admin/view_header',$data);
			echo view('admin/view_photo_add',$data);
			echo view('admin/view_footer');
        }
		
	}


	public function edit($id)
	{
		
    	// If there is no photo in this id, then redirect
    	$tot = $this->Model_photo->photo_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/photo');
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
		        $error .= 'You must have to select a photo<br>';
		    }

		    if($valid == 1)
		    {
		    	$data['photo'] = $this->Model_photo->getData($id);

				safe_unlink_upload($data['photo']['photo_name']);

				$final_name = 'photo-'.$id.'.'.$ext;
	        	move_uploaded_to_uploads($path_tmp, $final_name);

	        	$form_data = array(
					'photo_name' => $final_name
	            );
	            $this->Model_photo->update($id,$form_data);

				$success = 'Photo is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/photo');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/photo/edit'.$id);
		    }
           
		} else {
			$data['photo'] = $this->Model_photo->getData($id);
	       	echo view('admin/view_header',$data);
			echo view('admin/view_photo_edit',$data);
			echo view('admin/view_footer');
		}

	}


	public function delete($id) 
	{
		// If there is no photo in this id, then redirect
    	$tot = $this->Model_photo->photo_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/photo');
        	exit;
    	}

		if(PROJECT_MODE == 0) {
			$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
			redirect($_SERVER['HTTP_REFERER']);
		}

        $data['photo'] = $this->Model_photo->getData($id);
        if($data['photo']) {
            safe_unlink_upload($data['photo']['photo_name']);
        }

        $this->Model_photo->delete($id);
        $success = 'Photo is deleted successfully';
		$this->session->setFlashdata('success',$success);
        redirect(base_url().'admin/photo');
    }

}