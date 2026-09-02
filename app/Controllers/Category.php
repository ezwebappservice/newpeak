<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Category extends MY_Controller {
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Model_common();
        $this->Model_category = new \App\Models\Model_category();
        $this->Model_portfolio = new \App\Models\Model_portfolio();
    }

	public function index($id=0)
	{
		if( !isset($id) || !is_numeric($id) ) {
			redirect(base_url());
		}

		$tot = $this->Model_category->category_check($id);
		if(!$tot) {
			redirect(base_url());
		}


		$data['setting'] = $this->Model_common->all_setting();
		$data['page_home'] = $this->Model_common->all_page_home();
		$data['comment'] = $this->Model_common->all_comment();
		$data['social'] = $this->Model_common->all_social();
		$data['all_news'] = $this->Model_common->all_news();
		$data['all_categories'] = $this->Model_common->all_categories();
		
		$data['category'] = $this->Model_category->category_by_id($id);
		$data['news_by_category'] = $this->Model_category->all_news_by_category_id($id);

		$data['portfolio_footer'] = $this->Model_portfolio->get_portfolio_data();

		echo view('view_header',$data);
		echo view('view_category',$data);
		echo view('view_footer',$data);
	}
}