<?php
namespace App\Controllers\Admin;
use App\Controllers\MY_Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Page_dynamic extends MY_Controller 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_page_dynamic = new \App\Models\Admin\Model_page_dynamic();
    }

	public function index()
	{
		$data['setting'] = $this->Model_common->get_setting_data();
		$filter = $this->request->getGet('status') ?? 'active';
		if (! in_array($filter, ['all', 'active', 'inactive'], true)) {
			$filter = 'active';
		}
		$data['status_filter'] = $filter;
		$data['page_dynamic'] = $this->Model_page_dynamic->show($filter);

		echo view('admin/view_header',$data);
		echo view('admin/view_page_dynamic',$data);
		echo view('admin/view_footer');
	}

	public function add()
	{
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

			$name = $this->request->getPost('name', true);
			$slug = $this->request->getPost('slug', true);
			$content = $this->request->getPost('content', true);
			$meta_title = $this->request->getPost('meta_title', true);
			$meta_description = $this->request->getPost('meta_description', true);
			$lang_id  = $this->request->getPost('lang_id', true);
			$status = $this->request->getPost('status', true) === 'Inactive' ? 'Inactive' : 'Active';

			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('content', 'Content', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

            $path = $_FILES['banner']['name'];
		    $path_tmp = $_FILES['banner']['tmp_name'];

		    if($path!='') {
		        $ext = pathinfo( $path, PATHINFO_EXTENSION );
		        $file_name = basename( $path, '.' . $ext );
		        $ext_check = $this->Model_common->extension_check_photo($ext);
		        if($ext_check == FALSE) {
		            $valid = 0;
		            $error .= 'You must have to upload jpg, jpeg, gif or png file for banner<br>';
		        }
		    } else {
		    	$valid = 0;
		        $error .= 'You must have to select a photo for banner<br>';
		    }


		    if($valid == 1) 
		    {
				$next_id = $this->Model_page_dynamic->get_auto_increment_id();
				foreach ($next_id as $row) {
		            $ai_id = $row['Auto_increment'];
		        }

		        if($slug == '') {
		    		$temp_string = strtolower($name);
		    		$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string);
		    	} else {
		    		$temp_string = strtolower($slug);
		    		$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string);
		    	}

		    	$tot_slug = $this->Model_page_dynamic->slug_duplication_check($slug);
				if($tot_slug) {
					$slug = $slug.'-1';
				}

		        $final_name = 'page-dynamic-banner-'.$ai_id.'.'.$ext;
		        move_uploaded_to_uploads($path_tmp, $final_name);

		        $form_data = array(
					'name'             => $name,
					'slug'             => $slug,
					'content'          => $content,
					'banner'           => $final_name,
					'meta_title'       => $meta_title,
					'meta_description' => $meta_description,
					'lang_id'          => $lang_id,
					'status'           => $status
	            );
	            $this->Model_page_dynamic->add($form_data);

		        $success = 'Dynamic Page is added successfully!';
		        $this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/page-dynamic');
		    } 
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/page-dynamic/add');
		    }
            
        } else {
            echo view('admin/view_header',$data);
			echo view('admin/view_page_dynamic_add',$data);
			echo view('admin/view_footer');
        }		
	}


	public function edit($id)
	{
    	// If there is no post in this id, then redirect
    	$tot = $this->Model_page_dynamic->page_dynamic_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/page-dynamic');
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

			$name = $this->request->getPost('name', true);
			$slug = $this->request->getPost('slug', true);
			$content = $this->request->getPost('content', true);
			$meta_title = $this->request->getPost('meta_title', true);
			$meta_description = $this->request->getPost('meta_description', true);
			$lang_id  = $this->request->getPost('lang_id', true);
			$status = $this->request->getPost('status', true) === 'Inactive' ? 'Inactive' : 'Active';

			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('content', 'Content', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

            $path = $_FILES['banner']['name'];
		    $path_tmp = $_FILES['banner']['tmp_name'];

		    if($path!='') {
		        $ext = pathinfo( $path, PATHINFO_EXTENSION );
		        $file_name = basename( $path, '.' . $ext );
		        $ext_check = $this->Model_common->extension_check_photo($ext);
		        if($ext_check == FALSE) {
		            $valid = 0;
		            $error .= 'You must have to upload jpg, jpeg, gif or png file for banner<br>';
		        }
		    }

		    if($valid == 1) 
		    {
		    	$data['page_dynamic'] = $this->Model_page_dynamic->getData($id);

		    	if($slug == '') {
		    		$temp_string = strtolower($name);
		    		$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string);
		    	} else {
		    		$temp_string = strtolower($slug);
		    		$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string);
		    	}

		    	$tot_slug = $this->Model_page_dynamic->slug_duplication_check_edit($slug,$data['page_dynamic']['slug']);
				if($tot_slug) {
					$slug = $slug.'-1';
				}

		    	if($path == '')
		    	{
		    		$form_data = array(
						'name'             => $name,
						'slug'             => $slug,
						'content'          => $content,
						'meta_title'       => $meta_title,
						'meta_description' => $meta_description,
						'lang_id'          => $lang_id,
						'status'           => $status
		            );
		            $this->Model_page_dynamic->update($id,$form_data);
				}
				else
				{
					safe_unlink_upload($data['page_dynamic']['banner']);

					$final_name = 'page-dynamic-banner-'.$id.'.'.$ext;
		        	move_uploaded_to_uploads($path_tmp, $final_name);

		        	$form_data = array(
						'name'             => $name,
						'slug'             => $slug,
						'content'          => $content,
						'banner'           => $final_name,
						'meta_title'       => $meta_title,
						'meta_description' => $meta_description,
						'lang_id'          => $lang_id,
						'status'           => $status
		            );
		            $this->Model_page_dynamic->update($id,$form_data);
				}

				$success = 'Dynamic Page is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/page-dynamic');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/page-dynamic/add');
		    }
           
		} else {
			$data['page_dynamic'] = $this->Model_page_dynamic->getData($id);
            echo view('admin/view_header',$data);
			echo view('admin/view_page_dynamic_edit',$data);
			echo view('admin/view_footer');
		}
	}


	public function delete($id) 
	{
    	$tot = $this->Model_page_dynamic->page_dynamic_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/page-dynamic');
        	exit;
    	}

		if(PROJECT_MODE == 0) {
			$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
			redirect($_SERVER['HTTP_REFERER']);
		}

        $data['page_dynamic'] = $this->Model_page_dynamic->getData($id);
        if($data['page_dynamic']) {
            safe_unlink_upload($data['page_dynamic']['banner']);
        }

        $this->Model_page_dynamic->delete($id);
        $success = 'Dynamic Page is deleted successfully';
		$this->session->setFlashdata('success',$success);
		redirect(base_url().'admin/page-dynamic');
    }
}