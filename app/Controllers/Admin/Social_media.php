<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;



class Social_media extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_social_media = new \App\Models\Admin\Model_social_media();
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

			$networks = [
				'Facebook'    => 'facebook',
				'Twitter'     => 'twitter',
				'LinkedIn'    => 'linkedin',
				'Google Plus' => 'googleplus',
				'YouTube'     => 'youtube',
				'Instagram'   => 'instagram',
			];

			foreach ($networks as $socialName => $field) {
				if (! array_key_exists($field, $_POST)) {
					continue;
				}
				$this->Model_social_media->update($socialName, [
					'social_url' => trim((string) $_POST[$field]),
				]);
			}

			$success = 'Social Media is updated successfully';
		    
			$this->session->setFlashdata('success',$success);
			redirect(base_url().'admin/social_media');
           
		} else {
			$data['social'] = $this->Model_social_media->show();
	       	echo view('admin/view_header',$data);
			echo view('admin/view_social_media',$data);
			echo view('admin/view_footer');
		}

	}


}
