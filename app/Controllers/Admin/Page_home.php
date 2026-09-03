<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Page_home extends BaseController 
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) 
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_page_home = new \App\Models\Admin\Model_page_home();
    }

    public function index()
	{
		$error = '';
		$success = '';

		$data['setting'] = $this->Model_common->get_setting_data();
		$data['page_home'] = $this->Model_page_home->show();
		$data['page_home_lang_independent'] = $this->Model_page_home->show_lang_independent();

		echo view('admin/view_header',$data);
		echo view('admin/view_page_home',$data);
		echo view('admin/view_footer');
		
	}

	public function edit($id)
	{
		
    	$tot = $this->Model_page_home->page_home_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/page-home');
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

			$title = $this->request->getPost('title', true);
			$meta_keyword = $this->request->getPost('meta_keyword', true);
			$meta_description = $this->request->getPost('meta_description', true);
			$home_welcome_title = $this->request->getPost('home_welcome_title', true);
			$home_welcome_subtitle = $this->request->getPost('home_welcome_subtitle', true);
			$home_welcome_text = $this->request->getPost('home_welcome_text', true);
			$home_welcome_pbar1_text = $this->request->getPost('home_welcome_pbar1_text', true);
			$home_welcome_pbar1_value = $this->request->getPost('home_welcome_pbar1_value', true);
			$home_welcome_pbar2_text = $this->request->getPost('home_welcome_pbar2_text', true);
			$home_welcome_pbar2_value = $this->request->getPost('home_welcome_pbar2_value', true);
			$home_welcome_pbar3_text = $this->request->getPost('home_welcome_pbar3_text', true);
			$home_welcome_pbar3_value = $this->request->getPost('home_welcome_pbar3_value', true);
			$home_welcome_pbar4_text = $this->request->getPost('home_welcome_pbar4_text', true);
			$home_welcome_pbar4_value = $this->request->getPost('home_welcome_pbar4_value', true);
			$home_welcome_pbar5_text = $this->request->getPost('home_welcome_pbar5_text', true);
			$home_welcome_pbar5_value = $this->request->getPost('home_welcome_pbar5_value', true);
			$home_why_choose_title = $this->request->getPost('home_why_choose_title', true);
			$home_why_choose_subtitle = $this->request->getPost('home_why_choose_subtitle', true);
			$home_feature_title = $this->request->getPost('home_feature_title', true);
			$home_feature_subtitle = $this->request->getPost('home_feature_subtitle', true);
			$home_service_title = $this->request->getPost('home_service_title', true);
			$home_service_subtitle = $this->request->getPost('home_service_subtitle', true);
			$counter_1_title = $this->request->getPost('counter_1_title', true);
			$counter_1_value = $this->request->getPost('counter_1_value', true);
			$counter_1_icon = $this->request->getPost('counter_1_icon', true);
			$counter_2_title = $this->request->getPost('counter_2_title', true);
			$counter_2_value = $this->request->getPost('counter_2_value', true);
			$counter_2_icon = $this->request->getPost('counter_2_icon', true);
			$counter_3_title = $this->request->getPost('counter_3_title', true);
			$counter_3_value = $this->request->getPost('counter_3_value', true);
			$counter_3_icon = $this->request->getPost('counter_3_icon', true);
			$counter_4_title = $this->request->getPost('counter_4_title', true);
			$counter_4_value = $this->request->getPost('counter_4_value', true);
			$counter_4_icon = $this->request->getPost('counter_4_icon', true);
			$counter_5_title = $this->request->getPost('counter_5_title', true);
			$counter_5_value = $this->request->getPost('counter_5_value', true);
			$counter_5_icon = $this->request->getPost('counter_5_icon', true);
			$home_portfolio_title = $this->request->getPost('home_portfolio_title', true);
			$home_portfolio_subtitle = $this->request->getPost('home_portfolio_subtitle', true);
			$home_booking_form_title = $this->request->getPost('home_booking_form_title', true);
			$home_booking_faq_title = $this->request->getPost('home_booking_faq_title', true);
			$home_team_title = $this->request->getPost('home_team_title', true);
			$home_team_subtitle = $this->request->getPost('home_team_subtitle', true);
			$home_ptable_title = $this->request->getPost('home_ptable_title', true);
			$home_ptable_subtitle = $this->request->getPost('home_ptable_subtitle', true);
			$home_testimonial_title = $this->request->getPost('home_testimonial_title', true);
			$home_testimonial_subtitle = $this->request->getPost('home_testimonial_subtitle', true);
			$home_blog_title = $this->request->getPost('home_blog_title', true);
			$home_blog_subtitle = $this->request->getPost('home_blog_subtitle', true);
			$hero_badge = $this->request->getPost('hero_badge', true);
			$hero_title_prefix = $this->request->getPost('hero_title_prefix', true);
			$hero_title_highlight = $this->request->getPost('hero_title_highlight', true);
			$hero_lead = $this->request->getPost('hero_lead', true);
			$hero_btn1_text = $this->request->getPost('hero_btn1_text', true);
			$hero_btn1_url = $this->request->getPost('hero_btn1_url', true);
			$hero_btn2_text = $this->request->getPost('hero_btn2_text', true);
			$hero_btn2_url = $this->request->getPost('hero_btn2_url', true);
			$home_vision_title = $this->request->getPost('home_vision_title', true);
			$home_vision_text = $this->request->getPost('home_vision_text', true);
			$home_mission_title = $this->request->getPost('home_mission_title', true);
			$home_mission_text = $this->request->getPost('home_mission_text', true);
			$home_service_intro = $this->request->getPost('home_service_intro', true);
			$home_feature_intro = $this->request->getPost('home_feature_intro', true);
			$home_why_choose_intro = $this->request->getPost('home_why_choose_intro', true);
			$home_cert_title = $this->request->getPost('home_cert_title', true);
			$home_cert_subtitle = $this->request->getPost('home_cert_subtitle', true);
			$home_cert_intro = $this->request->getPost('home_cert_intro', true);
			$home_partners_tagline = $this->request->getPost('home_partners_tagline', true);
			$home_feature_mini1_title = $this->request->getPost('home_feature_mini1_title', true);
			$home_feature_mini1_text = $this->request->getPost('home_feature_mini1_text', true);
			$home_feature_mini1_icon = $this->request->getPost('home_feature_mini1_icon', true);
			$home_feature_mini2_title = $this->request->getPost('home_feature_mini2_title', true);
			$home_feature_mini2_text = $this->request->getPost('home_feature_mini2_text', true);
			$home_feature_mini2_icon = $this->request->getPost('home_feature_mini2_icon', true);
			$counter_1_suffix = $this->request->getPost('counter_1_suffix', true);
			$counter_2_suffix = $this->request->getPost('counter_2_suffix', true);
			$counter_3_suffix = $this->request->getPost('counter_3_suffix', true);
			$counter_4_suffix = $this->request->getPost('counter_4_suffix', true);
			$counter_5_suffix = $this->request->getPost('counter_5_suffix', true);
			$home_welcome_video = $this->request->getPost('home_welcome_video');

			$this->form_validation->set_rules('title', 'Title', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

		    if($valid == 1) 
		    {
	    		$existing = $this->Model_page_home->get_page_home($id);

	    		$form_data = array(
					'title' => $title,
					'meta_keyword' => $meta_keyword,
					'meta_description' => $meta_description,
					'home_welcome_title' => $home_welcome_title,
					'home_welcome_subtitle' => $home_welcome_subtitle,
					'home_welcome_text' => $home_welcome_text,
					'home_welcome_pbar1_text' => $home_welcome_pbar1_text,
					'home_welcome_pbar1_value' => $home_welcome_pbar1_value ?: ($existing['home_welcome_pbar1_value'] ?? ''),
					'home_welcome_pbar2_text' => $home_welcome_pbar2_text,
					'home_welcome_pbar2_value' => $home_welcome_pbar2_value ?: ($existing['home_welcome_pbar2_value'] ?? ''),
					'home_welcome_pbar3_text' => $existing['home_welcome_pbar3_text'] ?? '',
					'home_welcome_pbar3_value' => $existing['home_welcome_pbar3_value'] ?? '',
					'home_welcome_pbar4_text' => $existing['home_welcome_pbar4_text'] ?? '',
					'home_welcome_pbar4_value' => $existing['home_welcome_pbar4_value'] ?? '',
					'home_welcome_pbar5_text' => $existing['home_welcome_pbar5_text'] ?? '',
					'home_welcome_pbar5_value' => $existing['home_welcome_pbar5_value'] ?? '',
					'home_why_choose_title' => $home_why_choose_title,
					'home_why_choose_subtitle' => $home_why_choose_subtitle,
					'home_feature_title' => $home_feature_title,
					'home_feature_subtitle' => $home_feature_subtitle,
					'home_service_title' => $home_service_title,
					'home_service_subtitle' => $home_service_subtitle,
					'counter_1_title' => $counter_1_title,
					'counter_1_value' => $counter_1_value,
					'counter_1_icon' => $counter_1_icon,
					'counter_2_title' => $counter_2_title,
					'counter_2_value' => $counter_2_value,
					'counter_2_icon' => $counter_2_icon,
					'counter_3_title' => $counter_3_title,
					'counter_3_value' => $counter_3_value,
					'counter_3_icon' => $counter_3_icon,
					'counter_4_title' => $counter_4_title,
					'counter_4_value' => $counter_4_value,
					'counter_4_icon' => $counter_4_icon,
					'counter_5_title' => $counter_5_title,
					'counter_5_value' => $counter_5_value,
					'counter_5_icon' => $counter_5_icon,
					'home_portfolio_title' => $existing['home_portfolio_title'] ?? '',
					'home_portfolio_subtitle' => $existing['home_portfolio_subtitle'] ?? '',
					'home_booking_form_title' => $existing['home_booking_form_title'] ?? '',
					'home_booking_faq_title' => $existing['home_booking_faq_title'] ?? '',
					'home_team_title' => $existing['home_team_title'] ?? '',
					'home_team_subtitle' => $existing['home_team_subtitle'] ?? '',
					'home_ptable_title' => $existing['home_ptable_title'] ?? '',
					'home_ptable_subtitle' => $existing['home_ptable_subtitle'] ?? '',
					'home_testimonial_title' => $home_testimonial_title,
					'home_testimonial_subtitle' => $home_testimonial_subtitle,
					'home_blog_title' => $home_blog_title,
					'home_blog_subtitle' => $home_blog_subtitle,
					'hero_badge' => $hero_badge,
					'hero_title_prefix' => $hero_title_prefix,
					'hero_title_highlight' => $hero_title_highlight,
					'hero_lead' => $hero_lead,
					'hero_btn1_text' => $hero_btn1_text,
					'hero_btn1_url' => $hero_btn1_url,
					'hero_btn2_text' => $hero_btn2_text,
					'hero_btn2_url' => $hero_btn2_url,
					'home_vision_title' => $home_vision_title,
					'home_vision_text' => $home_vision_text,
					'home_mission_title' => $home_mission_title,
					'home_mission_text' => $home_mission_text,
					'home_service_intro' => $home_service_intro,
					'home_feature_intro' => $home_feature_intro,
					'home_why_choose_intro' => $home_why_choose_intro,
					'home_cert_title' => $home_cert_title,
					'home_cert_subtitle' => $home_cert_subtitle,
					'home_cert_intro' => $home_cert_intro,
					'home_partners_tagline' => $home_partners_tagline,
					'home_feature_mini1_title' => $home_feature_mini1_title,
					'home_feature_mini1_text' => $home_feature_mini1_text,
					'home_feature_mini1_icon' => $home_feature_mini1_icon,
					'home_feature_mini2_title' => $home_feature_mini2_title,
					'home_feature_mini2_text' => $home_feature_mini2_text,
					'home_feature_mini2_icon' => $home_feature_mini2_icon,
					'counter_1_suffix' => $counter_1_suffix,
					'counter_2_suffix' => $counter_2_suffix,
					'counter_3_suffix' => $counter_3_suffix,
					'counter_4_suffix' => $counter_4_suffix,
					'counter_5_suffix' => $counter_5_suffix,
	            );
	            $this->Model_page_home->update($id,$form_data);

	            if ($home_welcome_video !== null) {
	            	$this->Model_page_home->update_home([
	            		'home_welcome_video' => trim((string) $home_welcome_video),
	            	]);
	            }
				
				$success = 'Home Page information is updated successfully';
				$this->session->setFlashdata('success',$success);
				redirect(base_url().'admin/page-home');
		    }
		    else
		    {
		    	$this->session->setFlashdata('error',$error);
				redirect(base_url().'admin/page-home/edit'.$id);
		    }
           
		} else {
			$data['page_home'] = $this->Model_page_home->get_page_home($id);
			$data['page_home_lang_independent'] = $this->Model_page_home->show_lang_independent();
	       	echo view('admin/view_header',$data);
			echo view('admin/view_page_home_edit',$data);
			echo view('admin/view_footer');
		}

	}


	public function update()
	{
		$error = '';
		$success = '';
		$page = $this->Model_page_home->show_lang_independent() ?? [];

		if(isset($_POST['form_home_hero'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

        	$form_data = array(
				'home_hero_status' => $_POST['home_hero_status']
            );
        	$this->Model_page_home->update_home($form_data);
        	$success = 'Hero section visibility updated successfully!';
        	$this->session->setFlashdata('success',$success);
		    redirect(base_url().'admin/page-home');
		}

		if(isset($_POST['form_home_certification'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

        	$form_data = array(
				'home_certification_status' => $_POST['home_certification_status']
            );
        	$this->Model_page_home->update_home($form_data);
        	$success = 'Certifications section visibility updated successfully!';
        	$this->session->setFlashdata('success',$success);
		    redirect(base_url().'admin/page-home');
		}

		if(isset($_POST['form_home_partners'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

        	$form_data = array(
				'home_partners_status' => $_POST['home_partners_status']
            );
        	$this->Model_page_home->update_home($form_data);
        	$success = 'Partners section visibility updated successfully!';
        	$this->session->setFlashdata('success',$success);
		    redirect(base_url().'admin/page-home');
		}

		if(isset($_POST['form_home_welcome'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

        	$form_data = array(
				'home_welcome_status' => $_POST['home_welcome_status']
            );
            if (isset($_POST['home_welcome_video'])) {
            	$form_data['home_welcome_video'] = trim((string) $_POST['home_welcome_video']);
            }
        	$this->Model_page_home->update_home($form_data);
        	$success = 'Home page video section is updated successfully!';
        	$this->session->setFlashdata('success',$success);
		    redirect(base_url().'admin/page-home');
		}

		if(isset($_POST['form_home_welcome_video_bg'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

			$valid = 1;
			$path = $_FILES['home_welcome_video_bg']['name'];
		    $path_tmp = $_FILES['home_welcome_video_bg']['tmp_name'];
		    if($path!='') {
		        $ext = pathinfo( $path, PATHINFO_EXTENSION );
		        $file_name = basename( $path, '.' . $ext );
		        $ext_check = $this->Model_common->extension_check_photo($ext);
		        if($ext_check == FALSE) {
		            $valid = 0;
		            $error = 'You must have to upload jpg, jpeg, gif or png file<br>';
		        }
		    } else {
		    	$valid = 0;
		        $error = 'You must have to select a photo<br>';
		    }
		    if($valid == 1) {
		    	safe_unlink_upload($page['home_welcome_video_bg'] ?? '');

		    	$final_name = 'home_welcome_video_bg'.'.'.$ext;
		        move_uploaded_to_uploads($path_tmp, $final_name);
		    			        
				$form_data = array(
					'home_welcome_video_bg' => $final_name
	            );
	        	$this->Model_page_home->update_home($form_data);

	        	$success = 'Home page welcome video background is updated successfully!';
		    	$this->session->setFlashdata('success',$success);
		    	redirect(base_url().'admin/page-home');
		    } else {
		    	$this->session->setFlashdata('error',$error);
		    	redirect(base_url().'admin/page-home');
		    }
		}



		if(isset($_POST['form_home_why_choose'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

        	$form_data = array(
				'home_why_choose_status' => $_POST['home_why_choose_status']
            );
        	$this->Model_page_home->update_home($form_data);
        	$success = 'Home page why choose us information is updated successfully!';
        	$this->session->setFlashdata('success',$success);
		    redirect(base_url().'admin/page-home');
		}


		if(isset($_POST['form_home_feature'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

        	$form_data = array(
				'home_feature_status' => $_POST['home_feature_status']
            );
        	$this->Model_page_home->update_home($form_data);
        	$success = 'Home page feature information is updated successfully!';
        	$this->session->setFlashdata('success',$success);
		    redirect(base_url().'admin/page-home');
		}

		if(isset($_POST['form_home_service'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

        	$form_data = array(
				'home_service_status' => $_POST['home_service_status']
            );
        	$this->Model_page_home->update_home($form_data);
        	$success = 'Home page service information is updated successfully!';
        	$this->session->setFlashdata('success',$success);
		    redirect(base_url().'admin/page-home');
		}


		if(isset($_POST['form_home_counter_text'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

        	$form_data = array(
				'counter_status' => $_POST['counter_status']
            );
        	$this->Model_page_home->update_home($form_data);
        	$success = 'Home page counter information is updated successfully!';
        	$this->session->setFlashdata('success',$success);
		    redirect(base_url().'admin/page-home');
		}

		if(isset($_POST['form_home_counter_photo'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

			$valid = 1;
			$path = $_FILES['counter_photo']['name'];
		    $path_tmp = $_FILES['counter_photo']['tmp_name'];
		    if($path!='') {
		        $ext = pathinfo( $path, PATHINFO_EXTENSION );
		        $file_name = basename( $path, '.' . $ext );
		        $ext_check = $this->Model_common->extension_check_photo($ext);
		        if($ext_check == FALSE) {
		            $valid = 0;
		            $error = 'You must have to upload jpg, jpeg, gif or png file<br>';
		        }
		    } else {
		    	$valid = 0;
		        $error = 'You must have to select a photo<br>';
		    }
		    if($valid == 1) {
		    	safe_unlink_upload($page['counter_photo'] ?? '');
		    	$final_name = 'counter'.'.'.$ext;
		        move_uploaded_to_uploads($path_tmp, $final_name);
		    			        
				$form_data = array(
					'counter_photo' => $final_name
	            );
	        	$this->Model_page_home->update_home($form_data);

	        	$success = 'Home page counter photo is updated successfully!';
		    	$this->session->setFlashdata('success',$success);
		    	redirect(base_url().'admin/page-home');
		    } else {
		    	$this->session->setFlashdata('error',$error);
		    	redirect(base_url().'admin/page-home');
		    }
		}

		if(isset($_POST['form_home_portfolio'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

        	$form_data = array(
				'home_portfolio_status' => $_POST['home_portfolio_status']
            );
        	$this->Model_page_home->update_home($form_data);
        	$success = 'Home page portfolio information is updated successfully!';
        	$this->session->setFlashdata('success',$success);
		    redirect(base_url().'admin/page-home');
		}

		if(isset($_POST['form_home_booking'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

        	$form_data = array(
				'home_booking_status' => $_POST['home_booking_status']
            );
        	$this->Model_page_home->update_home($form_data);
        	$success = 'Home page booking information is updated successfully!';
        	$this->session->setFlashdata('success',$success);
		    redirect(base_url().'admin/page-home');
		}


		if(isset($_POST['form_home_booking_photo'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

			$valid = 1;
			$path = $_FILES['home_booking_photo']['name'];
		    $path_tmp = $_FILES['home_booking_photo']['tmp_name'];
		    if($path!='') {
		        $ext = pathinfo( $path, PATHINFO_EXTENSION );
		        $file_name = basename( $path, '.' . $ext );
		        $ext_check = $this->Model_common->extension_check_photo($ext);
		        if($ext_check == FALSE) {
		            $valid = 0;
		            $error = 'You must have to upload jpg, jpeg, gif or png file<br>';
		        }
		    } else {
		    	$valid = 0;
		        $error = 'You must have to select a photo<br>';
		    }
		    if($valid == 1) {
		    	// removing the existing photo
		    	safe_unlink_upload($page['home_booking_photo'] ?? '');

		    	// updating the data
		    	$final_name = 'home_booking_photo'.'.'.$ext;
		        move_uploaded_to_uploads($path_tmp, $final_name);
		    			        
				$form_data = array(
					'home_booking_photo' => $final_name
	            );
	        	$this->Model_page_home->update_home($form_data);

	        	$success = 'Home page booking photo is updated successfully!';
		    	$this->session->setFlashdata('success',$success);
		    	redirect(base_url().'admin/page-home');
		    } else {
		    	$this->session->setFlashdata('error',$error);
		    	redirect(base_url().'admin/page-home');
		    }
		}




		if(isset($_POST['form_home_team'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

        	$form_data = array(
				'home_team_status' => $_POST['home_team_status']
            );
        	$this->Model_page_home->update_home($form_data);
        	$success = 'Home page team information is updated successfully!';
        	$this->session->setFlashdata('success',$success);
		    redirect(base_url().'admin/page-home');
		}

		if(isset($_POST['form_home_pricing_table'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

        	$form_data = array(
				'home_ptable_status' => $_POST['home_ptable_status']
            );
        	$this->Model_page_home->update_home($form_data);
        	$success = 'Home page pricing table information is updated successfully!';
        	$this->session->setFlashdata('success',$success);
		    redirect(base_url().'admin/page-home');
		}

		if(isset($_POST['form_home_testimonial'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

        	$form_data = array(
				'home_testimonial_status' => $_POST['home_testimonial_status']
            );
        	$this->Model_page_home->update_home($form_data);
        	$success = 'Home page testimonial information is updated successfully!';
        	$this->session->setFlashdata('success',$success);
		    redirect(base_url().'admin/page-home');
		}

		if(isset($_POST['form_home_testimonial_photo'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

			$valid = 1;
			$path = $_FILES['home_testimonial_photo']['name'];
		    $path_tmp = $_FILES['home_testimonial_photo']['tmp_name'];
		    if($path!='') {
		        $ext = pathinfo( $path, PATHINFO_EXTENSION );
		        $file_name = basename( $path, '.' . $ext );
		        $ext_check = $this->Model_common->extension_check_photo($ext);
		        if($ext_check == FALSE) {
		            $valid = 0;
		            $error = 'You must have to upload jpg, jpeg, gif or png file<br>';
		        }
		    } else {
		    	$valid = 0;
		        $error = 'You must have to select a photo<br>';
		    }
		    if($valid == 1) {
		    	// removing the existing photo
		    	safe_unlink_upload($page['home_testimonial_photo'] ?? '');

		    	// updating the data
		    	$final_name = 'home_testimonial_photo'.'.'.$ext;
		        move_uploaded_to_uploads($path_tmp, $final_name);
		    			        
				$form_data = array(
					'home_testimonial_photo' => $final_name
	            );
	        	$this->Model_page_home->update_home($form_data);

	        	$success = 'Home page testimonial photo is updated successfully!';
		    	$this->session->setFlashdata('success',$success);
		    	redirect(base_url().'admin/page-home');
		    } else {
		    	$this->session->setFlashdata('error',$error);
		    	redirect(base_url().'admin/page-home');
		    }
		}


		if(isset($_POST['form_home_blog'])) {

			if(PROJECT_MODE == 0) {
				$this->session->setFlashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}
			
        	$form_data = array(
				'home_blog_item'   => $_POST['home_blog_item'],
				'home_blog_status' => $_POST['home_blog_status']
            );
        	$this->Model_page_home->update_home($form_data);
        	$success = 'Home page blog information is updated successfully!';
        	$this->session->setFlashdata('success',$success);
		    redirect(base_url().'admin/page-home');
		}




	}
	
}
