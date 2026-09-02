<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Search extends MY_Controller {
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Model_common();
        $this->Model_search = new \App\Models\Model_search();
        $this->Model_portfolio = new \App\Models\Model_portfolio();
    }

	public function index() {

		$data['setting'] = $this->Model_common->all_setting();
		$data['page_home'] = $this->Model_common->all_page_home();
		$data['page_search'] = $this->Model_common->all_page_search();
		$data['comment'] = $this->Model_common->all_comment();
		$data['social'] = $this->Model_common->all_social();
		$data['all_news'] = $this->Model_common->all_news();

		$data['portfolio_footer'] = $this->Model_portfolio->get_portfolio_data();

		$error2 = '';

		if(isset($_POST['search_string'])) {

			$data['search_string'] = $_POST['search_string'];
			$data['result'] = $this->Model_search->search($_POST['search_string']);
			$data['total'] = $this->Model_search->search_total($_POST['search_string']);

			echo view('view_header',$data);
			echo view('view_search',$data);
			echo view('view_footer',$data);

		} else {
			redirect(base_url());
		}

	}
}