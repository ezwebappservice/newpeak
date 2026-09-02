<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Testimonial extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_testimonial = new \App\Models\Admin\Model_testimonial();
    }

	public function index()
	{
		$data['setting'] = $this->Model_common->get_setting_data();

		$data['testimonial'] = $this->Model_testimonial->show();

		echo view('admin/view_header',$data);
		echo view('admin/view_testimonial',$data);
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
			$this->form_validation->set_rules('designation', 'Designation', 'trim|required');
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required');

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
				$next_id = $this->Model_testimonial->get_auto_increment_id();
				foreach ($next_id as $row) {
		            $ai_id = $row['Auto_increment'];
		        }

		        $final_name = 'testimonial-'.$ai_id.'.'.$ext;
		        move_uploaded_to_uploads($path_tmp, $final_name);

		        $form_data = array(
					'name'        => $_POST['name'],
					'designation' => $_POST['designation'],
					'photo'       => $final_name,
					'comment'     => $_POST['comment'],
					'lang_id'     => $_POST['lang_id']
	            );
	            $this->Model_testimonial->add($form_data);

		        $success = 'Testimonial is added successfully!';
		        $this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/testimonial');
		    } 
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/testimonial/add');
		    }
            
        } else {
            
            echo view('admin/view_header',$data);
			echo view('admin/view_testimonial_add',$data);
			echo view('admin/view_footer');
        }
		
	}


	public function edit($id)
	{
		
    	// If there is no testimonial in this id, then redirect
    	$tot = $this->Model_testimonial->testimonial_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/testimonial');
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
			$this->form_validation->set_rules('designation', 'Designation', 'trim|required');
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required');

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
		    	$data['testimonial'] = $this->Model_testimonial->get_testimonial($id);

		    	if($path == '') {
		    		$form_data = array(
						'name'        => $_POST['name'],
						'designation' => $_POST['designation'],
						'comment'     => $_POST['comment'],
						'lang_id'     => $_POST['lang_id']
		            );
		            $this->Model_testimonial->update($id,$form_data);
				}
				else {
					safe_unlink_upload($data['testimonial']['photo']);

					$final_name = 'testimonial-'.$id.'.'.$ext;
		        	move_uploaded_to_uploads($path_tmp, $final_name);

		        	$form_data = array(
						'name'        => $_POST['name'],
						'designation' => $_POST['designation'],
						'photo'       => $final_name,
						'comment'     => $_POST['comment'],
						'lang_id'     => $_POST['lang_id']
		            );
		            $this->Model_testimonial->update($id,$form_data);
				}
				
				$success = 'Testimonial is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/testimonial');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/testimonial/edit'.$id);
		    }
           
		} else {
			$data['testimonial'] = $this->Model_testimonial->get_testimonial($id);
	       	echo view('admin/view_header',$data);
			echo view('admin/view_testimonial_edit',$data);
			echo view('admin/view_footer');
		}

	}


	public function delete($id) 
	{
		// If there is no testimonial in this id, then redirect
    	$tot = $this->Model_testimonial->testimonial_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/testimonial');
        	exit;
    	}

		if(PROJECT_MODE == 0) {
			$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
			redirect($_SERVER['HTTP_REFERER']);
		}

        $data['testimonial'] = $this->Model_testimonial->get_testimonial($id);
        if($data['testimonial']) {
            safe_unlink_upload($data['testimonial']['photo']);
        }

        $this->Model_testimonial->delete($id);
        $success = 'Testimonial is deleted successfully';
		$this->session->setFlashdata('success',$success);
        redirect(base_url().'admin/testimonial');
    }

}