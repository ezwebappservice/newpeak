<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Page_faq extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_page_faq = new \App\Models\Admin\Model_page_faq();
    }

    public function index()
	{
		$error = '';
		$success = '';

		$data['setting'] = $this->Model_common->get_setting_data();
		$data['page_faq'] = $this->Model_page_faq->show();

		echo view('admin/view_header',$data);
		echo view('admin/view_page_faq',$data);
		echo view('admin/view_footer');
		
	}

	public function edit($id)
	{
		
    	$tot = $this->Model_page_faq->page_faq_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/page-faq');
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

			$faq_heading = $this->request->getPost('faq_heading', true);
			$mt_faq = $this->request->getPost('mt_faq', true);
			$mk_faq = $this->request->getPost('mk_faq', true);
			$md_faq = $this->request->getPost('md_faq', true);

			$this->form_validation->set_rules('faq_heading', 'Heading', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

		    if($valid == 1) 
		    {
	    		$form_data = array(
					'faq_heading' => $faq_heading,
					'mt_faq'      => $mt_faq,
					'mk_faq'      => $mk_faq,
					'md_faq'      => $md_faq
	            );
	            $this->Model_page_faq->update($id,$form_data);				
				
				$success = 'FAQ Page information is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/page-faq');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/page-faq/edit'.$id);
		    }
           
		} else {
			$data['page_faq'] = $this->Model_page_faq->get_page_faq($id);
	       	echo view('admin/view_header',$data);
			echo view('admin/view_page_faq_edit',$data);
			echo view('admin/view_footer');
		}

	}
	
}
