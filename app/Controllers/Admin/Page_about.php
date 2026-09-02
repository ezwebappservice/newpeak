<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Page_about extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_page_about = new \App\Models\Admin\Model_page_about();
    }

    public function index()
	{
		$error = '';
		$success = '';

		$data['setting'] = $this->Model_common->get_setting_data();
		$data['page_about'] = $this->Model_page_about->show();

		echo view('admin/view_header',$data);
		echo view('admin/view_page_about',$data);
		echo view('admin/view_footer');
		
	}

	public function edit($id)
	{
		
    	$tot = $this->Model_page_about->page_about_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/page-about');
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

			$about_heading = $this->request->getPost('about_heading', true);
			$about_content = $this->request->getPost('about_content', true);
			$mt_about = $this->request->getPost('mt_about', true);
			$mk_about = $this->request->getPost('mk_about', true);
			$md_about = $this->request->getPost('md_about', true);

			$this->form_validation->set_rules('about_heading', 'Heading', 'trim|required');
			$this->form_validation->set_rules('about_content', 'Content', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

		    if($valid == 1) 
		    {
	    		$form_data = array(
					'about_heading' => $about_heading,
					'about_content' => $about_content,
					'mt_about' => $mt_about,
					'mk_about' => $mk_about,
					'md_about' => $md_about
	            );
	            $this->Model_page_about->update($id,$form_data);				
				
				$success = 'About Page information is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/page-about');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/page-about/edit'.$id);
		    }
           
		} else {
			$data['page_about'] = $this->Model_page_about->get_page_about($id);
	       	echo view('admin/view_header',$data);
			echo view('admin/view_page_about_edit',$data);
			echo view('admin/view_footer');
		}

	}
	
}
