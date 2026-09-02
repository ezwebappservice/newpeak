<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Page_term extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_page_term = new \App\Models\Admin\Model_page_term();
    }

    public function index()
	{
		$error = '';
		$success = '';

		$data['setting'] = $this->Model_common->get_setting_data();
		$data['page_term'] = $this->Model_page_term->show();

		echo view('admin/view_header',$data);
		echo view('admin/view_page_term',$data);
		echo view('admin/view_footer');
		
	}

	public function edit($id)
	{
		
    	$tot = $this->Model_page_term->page_term_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/page-term');
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

			$term_heading = $this->request->getPost('term_heading', true);
			$term_content = $this->request->getPost('term_content', true);
			$mt_term = $this->request->getPost('mt_term', true);
			$mk_term = $this->request->getPost('mk_term', true);
			$md_term = $this->request->getPost('md_term', true);

			$this->form_validation->set_rules('term_heading', 'Heading', 'trim|required');
			$this->form_validation->set_rules('term_content', 'Content', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

		    if($valid == 1) 
		    {
	    		$form_data = array(
					'term_heading' => $term_heading,
					'term_content' => $term_content,
					'mt_term' => $mt_term,
					'mk_term' => $mk_term,
					'md_term' => $md_term
	            );
	            $this->Model_page_term->update($id,$form_data);				
				
				$success = 'Term Page information is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/page-term');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/page-term/edit'.$id);
		    }
           
		} else {
			$data['page_term'] = $this->Model_page_term->get_page_term($id);
	       	echo view('admin/view_header',$data);
			echo view('admin/view_page_term_edit',$data);
			echo view('admin/view_footer');
		}

	}
	
}
