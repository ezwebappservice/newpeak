<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Page_search extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_page_search = new \App\Models\Admin\Model_page_search();
    }

    public function index()
	{
		$error = '';
		$success = '';

		$data['setting'] = $this->Model_common->get_setting_data();
		$data['page_search'] = $this->Model_page_search->show();

		echo view('admin/view_header',$data);
		echo view('admin/view_page_search',$data);
		echo view('admin/view_footer');
		
	}

	public function edit($id)
	{
		
    	$tot = $this->Model_page_search->page_search_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/page-search');
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

			$search_heading = $this->request->getPost('search_heading', true);
			$mt_search = $this->request->getPost('mt_search', true);
			$mk_search = $this->request->getPost('mk_search', true);
			$md_search = $this->request->getPost('md_search', true);

			$this->form_validation->set_rules('search_heading', 'Heading', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

		    if($valid == 1) 
		    {
	    		$form_data = array(
					'search_heading' => $search_heading,
					'mt_search' => $mt_search,
					'mk_search' => $mk_search,
					'md_search' => $md_search
	            );
	            $this->Model_page_search->update($id,$form_data);				
				
				$success = 'Search Page information is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/page-search');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/page-search/edit'.$id);
		    }
           
		} else {
			$data['page_search'] = $this->Model_page_search->get_page_search($id);
	       	echo view('admin/view_header',$data);
			echo view('admin/view_page_search_edit',$data);
			echo view('admin/view_footer');
		}

	}
	
}
