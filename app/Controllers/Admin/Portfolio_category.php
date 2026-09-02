<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Portfolio_category extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_portfolio_category = new \App\Models\Admin\Model_portfolio_category();
    }

	public function index()
	{
		$data['setting'] = $this->Model_common->get_setting_data();

		$data['portfolio_category'] = $this->Model_portfolio_category->show();

		echo view('admin/view_header',$data);
		echo view('admin/view_portfolio_category',$data);
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

			$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error = validation_errors();
            }

		    if($valid == 1) 
		    {
				
		        $form_data = array(
					'category_name'=> $_POST['category_name'],
					'status'       => $_POST['status'],
					'lang_id'      => $_POST['lang_id']
	            );
	            $this->Model_portfolio_category->add($form_data);

		        $success = 'Portfolio category is added successfully!';
		        $this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/portfolio_category');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/portfolio_category/add');
		    }
            
        } else {
            
            echo view('admin/view_header',$data);
			echo view('admin/view_portfolio_category_add',$data);
			echo view('admin/view_footer');
        }
		
	}


	public function edit($id)
	{
    	$tot = $this->Model_portfolio_category->portfolio_category_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/portfolio_category');
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

			$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error = validation_errors();
            } else {

            	// Duplicate Category Checking
            	$data['portfolio_category'] = $this->Model_portfolio_category->getData($id);
            	$total = $this->Model_portfolio_category->duplicate_check($_POST['category_name'],$data['portfolio_category']['category_name']);				
		    	if($total) {
		    		$valid = 0;
		        	$error = 'Category name already exists';
		    	}
            }

		    if($valid == 1) 
		    {
	    		$form_data = array(
					'category_name'=> $_POST['category_name'],
					'status'       => $_POST['status'],
					'lang_id'      => $_POST['lang_id']
	            );
	            $this->Model_portfolio_category->update($id,$form_data);
				
				$success = 'Portfolio Category is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/portfolio_category');
		    }
		    else 
		    {
				$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/portfolio_category/add');
		    }
           
		} else {
			$data['portfolio_category'] = $this->Model_portfolio_category->getData($id);
			echo view('admin/view_header',$data);
			echo view('admin/view_portfolio_category_edit',$data);
			echo view('admin/view_footer');
		}

	}


	public function delete($id) 
	{
    	$tot = $this->Model_portfolio_category->portfolio_category_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/portfolio_category');
        	exit;
    	}

		if(PROJECT_MODE == 0) {
			$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
			redirect($_SERVER['HTTP_REFERER']);
		}


    	$result = $this->Model_portfolio_category->getData1($id);
		foreach ($result as $row) {
			$result1 = $this->Model_portfolio_category->show_portfolio_by_id($row['id']);
			foreach ($result1 as $row1) {
				$photo = $row1['photo'];
			}
			if($photo!='') {
				safe_unlink_upload($photo);
			}
			$result1 = $this->Model_portfolio_category->show_portfolio_photo_by_portfolio_id($row['id']);
			foreach ($result1 as $row1) {
				$photo = $row1['photo'];
				safe_unlink_upload($photo, 'portfolio_photos');
			}

			$this->Model_portfolio_category->delete1($row['id']);
			$this->Model_portfolio_category->delete2($row['id']);
		}
        $this->Model_portfolio_category->delete($id);
        
        $success = 'Portfolio category is deleted successfully';
        $this->session->setFlashdata('success',$success);
        redirect(base_url().'admin/portfolio_category');
    }

}