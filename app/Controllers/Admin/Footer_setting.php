<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Footer_setting extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_footer_setting = new \App\Models\Admin\Model_footer_setting();
    }

    public function index()
	{
		$data['setting'] = $this->Model_common->get_setting_data();
		$data['footer_setting_lang_independent'] = $this->Model_footer_setting->show_lang_independent();

		$rows = $this->Model_footer_setting->show();
		$data['footer_setting_row'] = $rows[0] ?? [];

		echo view('admin/view_header',$data);
		echo view('admin/view_footer_setting',$data);
		echo view('admin/view_footer');
	}

	public function edit($id)
	{
		
    	$tot = $this->Model_footer_setting->footer_setting_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/footer-setting');
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

			$newsletter_text = $this->request->getPost('newsletter_text', true);
			
			if($valid == 1) 
		    {
	    		$form_data = array(
					'newsletter_text' => $newsletter_text,
	            );
	            $this->Model_footer_setting->update($id,$form_data);				
				
				$success = 'Footer information is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/footer-setting');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/footer-setting/edit'.$id);
		    }
           
		} else {
			$data['footer_setting'] = $this->Model_footer_setting->get_footer_setting($id);
	       	echo view('admin/view_header',$data);
			echo view('admin/view_footer_setting_edit',$data);
			echo view('admin/view_footer');
		}

	}


	public function update()
	{
		if(isset($_POST['form_footer_settings'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

			$footerId = (int) ($this->request->getPost('footer_id') ?? 0);
			$newsletterText = $this->request->getPost('newsletter_text', true);

			if ($footerId > 0) {
				$this->Model_footer_setting->update($footerId, [
					'newsletter_text' => $newsletterText,
				]);
			}

        	$this->Model_footer_setting->update_footer_setting([
				'footer_recent_news_item' => (int) ($this->request->getPost('footer_recent_news_item') ?? 5),
            ]);

        	$this->session->setFlashdata('success', 'Footer settings updated successfully.');
		    redirect(base_url().'admin/footer-setting');
		}
	}
	
}
