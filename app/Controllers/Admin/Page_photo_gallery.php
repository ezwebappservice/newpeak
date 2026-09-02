<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Page_photo_gallery extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_page_photo_gallery = new \App\Models\Admin\Model_page_photo_gallery();
    }

    public function index()
	{
		$error = '';
		$success = '';

		$data['setting'] = $this->Model_common->get_setting_data();
		$data['page_photo_gallery'] = $this->Model_page_photo_gallery->show();

		echo view('admin/view_header',$data);
		echo view('admin/view_page_photo_gallery',$data);
		echo view('admin/view_footer');
		
	}

	public function edit($id)
	{
		
    	$tot = $this->Model_page_photo_gallery->page_photo_gallery_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/page-photo-gallery');
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

			$photo_gallery_heading = $this->request->getPost('photo_gallery_heading', true);
			$mt_photo_gallery = $this->request->getPost('mt_photo_gallery', true);
			$mk_photo_gallery = $this->request->getPost('mk_photo_gallery', true);
			$md_photo_gallery = $this->request->getPost('md_photo_gallery', true);

			$this->form_validation->set_rules('photo_gallery_heading', 'Heading', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

		    if($valid == 1) 
		    {
	    		$form_data = array(
					'photo_gallery_heading' => $photo_gallery_heading,
					'mt_photo_gallery' => $mt_photo_gallery,
					'mk_photo_gallery' => $mk_photo_gallery,
					'md_photo_gallery' => $md_photo_gallery
	            );
	            $this->Model_page_photo_gallery->update($id,$form_data);				
				
				$success = 'Photo Gallery Page information is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/page-photo-gallery');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/page-photo-gallery/edit'.$id);
		    }
           
		} else {
			$data['page_photo_gallery'] = $this->Model_page_photo_gallery->get_page_photo_gallery($id);
	       	echo view('admin/view_header',$data);
			echo view('admin/view_page_photo_gallery_edit',$data);
			echo view('admin/view_footer');
		}

	}
	
}
