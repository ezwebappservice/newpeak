<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Page_team extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_page_team = new \App\Models\Admin\Model_page_team();
    }

    public function index()
	{
		$error = '';
		$success = '';

		$data['setting'] = $this->Model_common->get_setting_data();
		$data['page_team'] = $this->Model_page_team->show();

		echo view('admin/view_header',$data);
		echo view('admin/view_page_team',$data);
		echo view('admin/view_footer');
		
	}

	public function edit($id)
	{
		
    	$tot = $this->Model_page_team->page_team_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/page-team');
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

            $team_heading = $this->request->getPost('team_heading', true);
            $team_subtitle = $this->request->getPost('team_subtitle', true);
            $team_intro = $this->request->getPost('team_intro', true);
            $mt_team = $this->request->getPost('mt_team', true);
			$mk_team = $this->request->getPost('mk_team', true);
			$md_team = $this->request->getPost('md_team', true);

			$this->form_validation->set_rules('team_heading', 'Heading', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

		    if($valid == 1) 
		    {
	    		$form_data = array(
					'team_heading' => $team_heading,
					'team_subtitle' => $team_subtitle,
					'team_intro' => $team_intro,
					'mt_team' => $mt_team,
					'mk_team' => $mk_team,
					'md_team' => $md_team
	            );
	            $this->Model_page_team->update($id,$form_data);				
				
				$success = 'Team Page information is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/page-team');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/page-team/edit'.$id);
		    }
           
		} else {
			$data['page_team'] = $this->Model_page_team->get_page_team($id);
	       	echo view('admin/view_header',$data);
			echo view('admin/view_page_team_edit',$data);
			echo view('admin/view_footer');
		}

	}
	
}
