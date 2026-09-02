<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Page_portfolio extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_page_portfolio = new \App\Models\Admin\Model_page_portfolio();
    }

    public function index()
	{
		$error = '';
		$success = '';

		$data['setting'] = $this->Model_common->get_setting_data();
		$data['page_portfolio'] = $this->Model_page_portfolio->show();

		echo view('admin/view_header',$data);
		echo view('admin/view_page_portfolio',$data);
		echo view('admin/view_footer');
		
	}

	public function edit($id)
	{
		
    	$tot = $this->Model_page_portfolio->page_portfolio_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/page-portfolio');
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

			$portfolio_heading = $this->request->getPost('portfolio_heading', true);
			$mt_portfolio = $this->request->getPost('mt_portfolio', true);
			$mk_portfolio = $this->request->getPost('mk_portfolio', true);
			$md_portfolio = $this->request->getPost('md_portfolio', true);

			$this->form_validation->set_rules('portfolio_heading', 'Heading', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

		    if($valid == 1) 
		    {
	    		$form_data = array(
					'portfolio_heading' => $portfolio_heading,
					'mt_portfolio' => $mt_portfolio,
					'mk_portfolio' => $mk_portfolio,
					'md_portfolio' => $md_portfolio
	            );
	            $this->Model_page_portfolio->update($id,$form_data);				
				
				$success = 'Portfolio Page information is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/page-portfolio');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/page-portfolio/edit'.$id);
		    }
           
		} else {
			$data['page_portfolio'] = $this->Model_page_portfolio->get_page_portfolio($id);
	       	echo view('admin/view_header',$data);
			echo view('admin/view_page_portfolio_edit',$data);
			echo view('admin/view_footer');
		}

	}
	
}
