<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Page_testimonial extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_page_testimonial = new \App\Models\Admin\Model_page_testimonial();
    }

    public function index()
	{
		$error = '';
		$success = '';

		$data['setting'] = $this->Model_common->get_setting_data();
		$data['page_testimonial'] = $this->Model_page_testimonial->show();

		echo view('admin/view_header',$data);
		echo view('admin/view_page_testimonial',$data);
		echo view('admin/view_footer');
		
	}

	public function edit($id)
	{
		
    	$tot = $this->Model_page_testimonial->page_testimonial_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/page-testimonial');
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

			$testimonial_heading = $this->request->getPost('testimonial_heading', true);
			$mt_testimonial = $this->request->getPost('mt_testimonial', true);
			$mk_testimonial = $this->request->getPost('mk_testimonial', true);
			$md_testimonial = $this->request->getPost('md_testimonial', true);

			$this->form_validation->set_rules('testimonial_heading', 'Heading', 'trim|required');
			
			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

		    if($valid == 1) 
		    {
	    		$form_data = array(
					'testimonial_heading' => $testimonial_heading,
					'mt_testimonial' => $mt_testimonial,
					'mk_testimonial' => $mk_testimonial,
					'md_testimonial' => $md_testimonial
	            );
	            $this->Model_page_testimonial->update($id,$form_data);				
				
				$success = 'Testimonial Page information is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/page-testimonial');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/page-testimonial/edit'.$id);
		    }
           
		} else {
			$data['page_testimonial'] = $this->Model_page_testimonial->get_page_testimonial($id);
	       	echo view('admin/view_header',$data);
			echo view('admin/view_page_testimonial_edit',$data);
			echo view('admin/view_footer');
		}

	}
	
}
