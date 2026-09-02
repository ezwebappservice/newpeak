<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Pricing_table extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_pricing_table = new \App\Models\Admin\Model_pricing_table();
    }

	public function index()
	{
		$data['setting'] = $this->Model_common->get_setting_data();

		$data['pricing_table'] = $this->Model_pricing_table->show();

		echo view('admin/view_header',$data);
		echo view('admin/view_pricing_table',$data);
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

			$this->form_validation->set_rules('icon', 'Icon', 'trim|required');
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			$this->form_validation->set_rules('subtitle', 'Subtitle', 'trim|required');
			$this->form_validation->set_rules('text', 'Text', 'trim|required');
			$this->form_validation->set_rules('button_text', 'Button Text', 'trim|required');
			$this->form_validation->set_rules('button_url', 'Button URL', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }
		    
		    if($valid == 1) 
		    {
		        $form_data = array(
					'icon'        => $_POST['icon'],
					'title'       => $_POST['title'],
					'price'       => $_POST['price'],
					'subtitle'    => $_POST['subtitle'],
					'text'        => $_POST['text'],
					'button_text' => $_POST['button_text'],
					'button_url'  => $_POST['button_url'],
					'lang_id'     => $_POST['lang_id']
	            );
	            $this->Model_pricing_table->add($form_data);

		        $success = 'Price table item is added successfully!';
		        $this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/pricing_table');
		    } 
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/pricing_table/add');
		    }
            
        } else {
            
            echo view('admin/view_header',$data);
			echo view('admin/view_pricing_table_add',$data);
			echo view('admin/view_footer');
        }
		
	}


	public function edit($id)
	{
		
    	// If there is no pricing table in this id, then redirect
    	$tot = $this->Model_pricing_table->pricing_table_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/pricing_table');
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

			$this->form_validation->set_rules('icon', 'Icon', 'trim|required');
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			$this->form_validation->set_rules('subtitle', 'Subtitle', 'trim|required');
			$this->form_validation->set_rules('text', 'Text', 'trim|required');
			$this->form_validation->set_rules('button_text', 'Button Text', 'trim|required');
			$this->form_validation->set_rules('button_url', 'Button URL', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }
		    
		    if($valid == 1) 
		    {
		    	$data['pricing_table'] = $this->Model_pricing_table->getData($id);
		    	
	    		$form_data = array(
					'icon'        => $_POST['icon'],
					'title'       => $_POST['title'],
					'price'       => $_POST['price'],
					'subtitle'    => $_POST['subtitle'],
					'text'        => $_POST['text'],
					'button_text' => $_POST['button_text'],
					'button_url'  => $_POST['button_url'],
					'lang_id'     => $_POST['lang_id']
	            );
	            $this->Model_pricing_table->update($id,$form_data);
				
				$success = 'Pricing table is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/pricing_table');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/pricing_table/edit/'.$id);
		    }
           
		} else {
			$data['pricing_table'] = $this->Model_pricing_table->getData($id);
	       	echo view('admin/view_header',$data);
			echo view('admin/view_pricing_table_edit',$data);
			echo view('admin/view_footer');
		}

	}


	public function delete($id) 
	{
		// If there is no pricing table in this id, then redirect
    	$tot = $this->Model_pricing_table->pricing_table_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/pricing_table');
        	exit;
    	}

		if(PROJECT_MODE == 0) {
			$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
			redirect($_SERVER['HTTP_REFERER']);
		}

        $this->Model_pricing_table->delete($id);
        $success = 'Pricing table is deleted successfully';
        $this->session->setFlashdata('success',$success);
        redirect(base_url().'admin/pricing_table');
    }

}