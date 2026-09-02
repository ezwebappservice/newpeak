<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Page_pricing extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_page_pricing = new \App\Models\Admin\Model_page_pricing();
    }

    public function index()
	{
		$error = '';
		$success = '';

		$data['setting'] = $this->Model_common->get_setting_data();
		$data['page_pricing'] = $this->Model_page_pricing->show();

		echo view('admin/view_header',$data);
		echo view('admin/view_page_pricing',$data);
		echo view('admin/view_footer');
		
	}

	public function edit($id)
	{
		
    	$tot = $this->Model_page_pricing->page_pricing_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/page-pricing');
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

			$pricing_heading = $this->request->getPost('pricing_heading', true);
			$mt_pricing = $this->request->getPost('mt_pricing', true);
			$mk_pricing = $this->request->getPost('mk_pricing', true);
			$md_pricing = $this->request->getPost('md_pricing', true);

			$this->form_validation->set_rules('pricing_heading', 'Heading', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

		    if($valid == 1) 
		    {
	    		$form_data = array(
					'pricing_heading' => $pricing_heading,
					'mt_pricing' => $mt_pricing,
					'mk_pricing' => $mk_pricing,
					'md_pricing' => $md_pricing
	            );
	            $this->Model_page_pricing->update($id,$form_data);				
				
				$success = 'Pricing Page information is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/page-pricing');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/page-pricing/edit'.$id);
		    }
           
		} else {
			$data['page_pricing'] = $this->Model_page_pricing->get_page_pricing($id);
	       	echo view('admin/view_header',$data);
			echo view('admin/view_page_pricing_edit',$data);
			echo view('admin/view_footer');
		}

	}
	
}
