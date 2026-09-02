<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Testimonial extends MY_Controller {
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Model_common();
        $this->Model_testimonial = new \App\Models\Model_testimonial();
        $this->Model_portfolio = new \App\Models\Model_portfolio();
    }

	public function index()
	{
		$data['setting'] = $this->Model_common->all_setting();
		$data['page_testimonial'] = $this->Model_common->all_page_testimonial();
		$data['comment'] = $this->Model_common->all_comment();
		$data['social'] = $this->Model_common->all_social();
		$data['all_news'] = $this->Model_common->all_news();

		$data['testimonials'] = $this->Model_testimonial->all_testimonial();
		$data['portfolio_footer'] = $this->Model_portfolio->get_portfolio_data();

		echo view('view_header',$data);
		echo view('view_testimonial',$data);
		echo view('view_footer',$data);
	}
}