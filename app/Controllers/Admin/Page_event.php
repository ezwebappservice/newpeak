<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Page_event extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_page_event = new \App\Models\Admin\Model_page_event();
    }

    public function index()
	{
		$error = '';
		$success = '';

		$data['setting'] = $this->Model_common->get_setting_data();
		$data['page_event'] = $this->Model_page_event->show();

		echo view('admin/view_header',$data);
		echo view('admin/view_page_event',$data);
		echo view('admin/view_footer');
		
	}

	public function edit($id)
	{
		
    	$tot = $this->Model_page_event->page_event_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/page-event');
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

			$event_heading = $this->request->getPost('event_heading', true);
			$mt_event = $this->request->getPost('mt_event', true);
			$mk_event = $this->request->getPost('mk_event', true);
			$md_event = $this->request->getPost('md_event', true);

			$this->form_validation->set_rules('event_heading', 'Heading', 'trim|required');
			
			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

		    if($valid == 1) 
		    {
	    		$form_data = array(
					'event_heading' => $event_heading,
					'mt_event' => $mt_event,
					'mk_event' => $mk_event,
					'md_event' => $md_event
	            );
	            $this->Model_page_event->update($id,$form_data);				
				
				$success = 'Event Page information is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/page-event');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/page-event/edit'.$id);
		    }
           
		} else {
			$data['page_event'] = $this->Model_page_event->get_page_event($id);
	       	echo view('admin/view_header',$data);
			echo view('admin/view_page_event_edit',$data);
			echo view('admin/view_footer');
		}

	}
	
}
