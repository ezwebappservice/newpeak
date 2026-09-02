<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;



class Comment extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_comment = new \App\Models\Admin\Model_comment();
    }

	public function index()
	{
       	
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

			$this->form_validation->set_rules('code_body', 'Comment Body Code', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error = validation_errors();
            }
            
		    if($valid == 1) 
		    {
		    	$data['comment'] = $this->Model_comment->show();

	    		$form_data = array(
					'code_body'  => $_POST['code_body']
	            );
	            $this->Model_comment->update($form_data);
				
				$success = 'Comment Body Code is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/comment');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/comment');
		    }
           
		} else {
			$data['comment'] = $this->Model_comment->show();
	       	echo view('admin/view_header',$data);
			echo view('admin/view_comment',$data);
			echo view('admin/view_footer');
		}

	}


}