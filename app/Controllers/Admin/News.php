<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class News extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        helper(['news', 'upload']);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_news = new \App\Models\Admin\Model_news();
    }

	public function index()
	{
		$data['setting'] = $this->Model_common->get_setting_data();
		$data['news'] = $this->Model_news->show();

		echo view('admin/view_header',$data);
		echo view('admin/view_news',$data);
		echo view('admin/view_footer');
	}

	public function add()
	{
		$data['setting'] = $this->Model_common->get_setting_data();
		$data['all_lang'] = $this->Model_common->all_lang();

		$error = '';
		$success = '';

		if(isset($_POST['form1'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

			$valid = 1;

			$this->form_validation->set_rules('news_title', 'News Title', 'trim|required');
			$this->form_validation->set_rules('news_content_short', 'News Short Content', 'trim|required');
			$this->form_validation->set_rules('news_content', 'News Content', 'trim|required');
			$this->form_validation->set_rules('category_id', 'Category', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

            $path = $_FILES['photo']['name'];
		    $path_tmp = $_FILES['photo']['tmp_name'];

		    if($path!='') {
		        $ext = pathinfo( $path, PATHINFO_EXTENSION );
		        $file_name = basename( $path, '.' . $ext );
		        $ext_check = $this->Model_common->extension_check_photo($ext);
		        if($ext_check == FALSE) {
		            $valid = 0;
		            $error .= 'You must have to upload jpg, jpeg, gif or png file for featured photo<br>';
		        }
		    } else {
		    	$valid = 0;
		        $error .= 'You must have to select a photo for featured photo<br>';
		    }

		    $path1 = $_FILES['banner']['name'];
		    $path_tmp1 = $_FILES['banner']['tmp_name'];

		    if($path1!='') {
		        $ext1 = pathinfo( $path1, PATHINFO_EXTENSION );
		        $file_name = basename( $path1, '.' . $ext1 );
		        $ext_check1 = $this->Model_common->extension_check_photo($ext1);
		        if($ext_check1 == FALSE) {
		            $valid = 0;
		            $error .= 'You must have to upload jpg, jpeg, gif or png file for banner<br>';
		        }
		    } else {
		    	$valid = 0;
		        $error .= 'You must have to select a photo for banner<br>';
		    }

		    if($valid == 1) 
		    {
				$next_id = $this->Model_news->get_auto_increment_id();
				foreach ($next_id as $row) {
		            $ai_id = $row['Auto_increment'];
		        }

		        $final_name = 'news-'.$ai_id.'.'.$ext;
		        move_uploaded_to_uploads($path_tmp, $final_name);

		        $final_name1 = 'news-banner-'.$ai_id.'.'.$ext1;
		        move_uploaded_to_uploads($path_tmp1, $final_name1);

		        $newsSlug = news_resolve_slug(
		            $_POST['news_title'],
		            $_POST['news_slug'] ?? null
		        );

		        $form_data = array(
					'news_title'         => $_POST['news_title'],
					'news_slug'          => $newsSlug,
					'news_content'       => $_POST['news_content'],
					'news_content_short' => $_POST['news_content_short'],
					'news_date'          => $_POST['news_date'],
					'photo'              => $final_name,
					'banner'             => $final_name1,
					'category_id'        => $_POST['category_id'],
					'comment'            => $_POST['comment'],
					'meta_title'         => $_POST['meta_title'],
					'meta_keyword'       => $_POST['meta_keyword'],
					'meta_description'   => $_POST['meta_description'],
					'lang_id'            => $_POST['lang_id']
	            );
	            $this->Model_news->add($form_data);

		        $success = 'News is added successfully!';
		        $this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/news');
		    } 
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/news/add');
		    }
            
        } else {
            $data['all_category'] = $this->Model_news->get_category();
            echo view('admin/view_header',$data);
			echo view('admin/view_news_add',$data);
			echo view('admin/view_footer');
        }
		
	}


	public function edit($id)
	{
		
    	// If there is no news in this id, then redirect
    	$tot = $this->Model_news->news_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/news');
        	exit;
    	}
       	
       	$data['setting'] = $this->Model_common->get_setting_data();
       	$data['all_lang'] = $this->Model_common->all_lang();

		$error = '';
		$success = '';

		if(isset($_POST['form1'])) 
		{

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

			$valid = 1;

			$this->form_validation->set_rules('news_title', 'News Title', 'trim|required');
			$this->form_validation->set_rules('news_content_short', 'News Short Content', 'trim|required');
			$this->form_validation->set_rules('news_content', 'News Content', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

            $path = $_FILES['photo']['name'];
		    $path_tmp = $_FILES['photo']['tmp_name'];

		    if($path!='') {
		        $ext = pathinfo( $path, PATHINFO_EXTENSION );
		        $file_name = basename( $path, '.' . $ext );
		        $ext_check = $this->Model_common->extension_check_photo($ext);
		        if($ext_check == FALSE) {
		            $valid = 0;
		            $error .= 'You must have to upload jpg, jpeg, gif or png file for featured photo<br>';
		        }
		    }

		    $path1 = $_FILES['banner']['name'];
		    $path_tmp1 = $_FILES['banner']['tmp_name'];

		    if($path1!='') {
		        $ext1 = pathinfo( $path1, PATHINFO_EXTENSION );
		        $file_name1 = basename( $path1, '.' . $ext1 );
		        $ext_check1 = $this->Model_common->extension_check_photo($ext1);
		        if($ext_check1 == FALSE) {
		            $valid = 0;
		            $error .= 'You must have to upload jpg, jpeg, gif or png file for banner<br>';
		        }
		    }

		    if($valid == 1) 
		    {
		    	$data['news'] = $this->Model_news->getData($id);

		    	$newsSlug = news_resolve_slug(
		    	    $_POST['news_title'],
		    	    $_POST['news_slug'] ?? null,
		    	    (int) $id
		    	);

		    	$baseFields = array(
					'news_title'         => $_POST['news_title'],
					'news_slug'          => $newsSlug,
					'news_content'       => $_POST['news_content'],
					'news_content_short' => $_POST['news_content_short'],
					'news_date'          => $_POST['news_date'],
					'category_id'        => $_POST['category_id'],
					'comment'            => $_POST['comment'],
					'meta_title'         => $_POST['meta_title'],
					'meta_keyword'       => $_POST['meta_keyword'],
					'meta_description'   => $_POST['meta_description'],
					'lang_id'            => $_POST['lang_id']
	            );

		    	if($path == '' && $path1 == '') {
		    		$this->Model_news->update($id, $baseFields);
				}
				if($path != '' && $path1 == '') {
					safe_unlink_upload($data['news']['photo']);

					$final_name = 'news-'.$id.'.'.$ext;
		        	move_uploaded_to_uploads($path_tmp, $final_name);

		        	$this->Model_news->update($id, array_merge($baseFields, ['photo' => $final_name]));
				}
				if($path == '' && $path1 != '') {
					safe_unlink_upload($data['news']['banner']);

					$final_name1 = 'news-banner-'.$id.'.'.$ext1;
		        	move_uploaded_to_uploads($path_tmp1, $final_name1);

		        	$this->Model_news->update($id, array_merge($baseFields, ['banner' => $final_name1]));
				}
				if($path != '' && $path1 != '') {

					safe_unlink_upload($data['news']['photo']);
					safe_unlink_upload($data['news']['banner']);

					$final_name = 'news-'.$id.'.'.$ext;
		        	move_uploaded_to_uploads($path_tmp, $final_name);

					$final_name1 = 'news-banner-'.$id.'.'.$ext1;
		        	move_uploaded_to_uploads($path_tmp1, $final_name1);

		        	$this->Model_news->update($id, array_merge($baseFields, [
		        	    'photo'  => $final_name,
		        	    'banner' => $final_name1,
		        	]));
				}

				$success = 'News is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/news');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/news/add');
		    }
           
		} else {
			$data['news'] = $this->Model_news->getData($id);
			$data['all_category'] = $this->Model_news->get_category();
            echo view('admin/view_header',$data);
			echo view('admin/view_news_edit',$data);
			echo view('admin/view_footer');
		}

	}


	public function delete($id) 
	{
    	$tot = $this->Model_news->news_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/news');
        	exit;
    	}

		if(PROJECT_MODE == 0) {
			$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
			redirect($_SERVER['HTTP_REFERER']);
		}

        $data['news'] = $this->Model_news->getData($id);
        if($data['news']) {
            safe_unlink_upload($data['news']['photo']);
            safe_unlink_upload($data['news']['banner']);
        }

        $this->Model_news->delete($id);
        $success = 'News is deleted successfully';
		$this->session->setFlashdata('success',$success);
		redirect(base_url().'admin/news');
    }

 
}