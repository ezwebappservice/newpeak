<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Page_news extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_page_news = new \App\Models\Admin\Model_page_news();
    }

    public function index()
	{
		$error = '';
		$success = '';

		$data['setting'] = $this->Model_common->get_setting_data();
		$data['page_news'] = $this->Model_page_news->show();

		echo view('admin/view_header',$data);
		echo view('admin/view_page_news',$data);
		echo view('admin/view_footer');
		
	}

	public function edit($id)
	{
		
    	$tot = $this->Model_page_news->page_news_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/page-news');
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

			$news_heading = $this->request->getPost('news_heading', true);
			$mt_news = $this->request->getPost('mt_news', true);
			$mk_news = $this->request->getPost('mk_news', true);
			$md_news = $this->request->getPost('md_news', true);

			$this->form_validation->set_rules('news_heading', 'Heading', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

		    if($valid == 1) 
		    {
	    		$form_data = array(
					'news_heading' => $news_heading,
					'mt_news' => $mt_news,
					'mk_news' => $mk_news,
					'md_news' => $md_news
	            );
	            $this->Model_page_news->update($id,$form_data);				
				
				$success = 'News Page information is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/page-news');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/page-news/edit'.$id);
		    }
           
		} else {
			$data['page_news'] = $this->Model_page_news->get_page_news($id);
	       	echo view('admin/view_header',$data);
			echo view('admin/view_page_news_edit',$data);
			echo view('admin/view_footer');
		}

	}
	
}
