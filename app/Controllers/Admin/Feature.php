<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Feature extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_feature = new \App\Models\Admin\Model_feature();
    }

	public function index()
	{
		$data['setting'] = $this->Model_common->get_setting_data();

		$data['feature'] = $this->Model_feature->show();

		echo view('admin/view_header',$data);
		echo view('admin/view_feature',$data);
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
			$this->form_validation->set_rules('content', 'Content', 'trim|required');
			$this->form_validation->set_rules('icon', 'Icon', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }
		    
		    if($valid == 1) 
		    {
		        $form_data = array(
					'name'    => $_POST['name'],
					'content' => $_POST['content'],
					'icon'    => $_POST['icon'],
					'lang_id' => $_POST['lang_id']
	            );
	            $this->Model_feature->add($form_data);

		        $success = 'Feature is added successfully!';
		        $this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/feature');
		    } 
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/feature/add');
		    }
            
        } else {
            
            echo view('admin/view_header',$data);
			echo view('admin/view_feature_add',$data);
			echo view('admin/view_footer');
        }
		
	}


	public function edit($id)
	{
    	$tot = $this->Model_feature->feature_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/feature');
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
			$this->form_validation->set_rules('content', 'Content', 'trim|required');
			$this->form_validation->set_rules('icon', 'Icon', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }
	    
		    if($valid == 1) 
		    {
		    	$data['feature'] = $this->Model_feature->getData($id);

	    		$form_data = array(
					'name'    => $_POST['name'],
					'content' => $_POST['content'],
					'icon'    => $_POST['icon'],
					'lang_id' => $_POST['lang_id']
	            );
	            $this->Model_feature->update($id,$form_data);
				
				$success = 'Feature is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/feature');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/feature/edit/'.$id);
		    }
           
		} else {
			$data['feature'] = $this->Model_feature->getData($id);
	       	echo view('admin/view_header',$data);
			echo view('admin/view_feature_edit',$data);
			echo view('admin/view_footer');
		}

	}


	public function delete($id) 
	{
    	$tot = $this->Model_feature->feature_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/feature');
        	exit;
    	}

		if(PROJECT_MODE == 0) {
			$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
			redirect($_SERVER['HTTP_REFERER']);
		}

        $data['feature'] = $this->Model_feature->getData($id);
        if($data['feature']) {
            safe_unlink_upload($data['feature']['photo']);
        }

        $this->Model_feature->delete($id);
        $success = 'Feature is deleted successfully';
        $this->session->setFlashdata('success',$success);
        redirect(base_url().'admin/feature');
    }

}