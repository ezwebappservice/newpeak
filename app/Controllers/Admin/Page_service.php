<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Page_service extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_page_service = new \App\Models\Admin\Model_page_service();
    }

    public function index()
	{
		$error = '';
		$success = '';

		$data['setting'] = $this->Model_common->get_setting_data();
		$data['page_service'] = $this->Model_page_service->show();

		echo view('admin/view_header',$data);
		echo view('admin/view_page_service',$data);
		echo view('admin/view_footer');
		
	}

	public function edit($id)
	{
		
    	$tot = $this->Model_page_service->page_service_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/page-service');
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

			$service_heading = $this->request->getPost('service_heading', true);
			$mt_service = $this->request->getPost('mt_service', true);
			$mk_service = $this->request->getPost('mk_service', true);
			$md_service = $this->request->getPost('md_service', true);

			$this->form_validation->set_rules('service_heading', 'Heading', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

		    if($valid == 1) 
		    {
	    		$form_data = array(
					'service_heading' => $service_heading,
					'mt_service' => $mt_service,
					'mk_service' => $mk_service,
					'md_service' => $md_service
	            );
	            $this->Model_page_service->update($id,$form_data);				
				
				$success = 'Service Page information is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/page-service');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/page-service/edit'.$id);
		    }
           
		} else {
			$data['page_service'] = $this->Model_page_service->get_page_service($id);
	       	echo view('admin/view_header',$data);
			echo view('admin/view_page_service_edit',$data);
			echo view('admin/view_footer');
		}

	}
	
}
