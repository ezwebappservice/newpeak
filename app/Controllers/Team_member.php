<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Team_member extends MY_Controller {
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Model_common();
        $this->Model_team_member = new \App\Models\Model_team_member();
        $this->Model_portfolio = new \App\Models\Model_portfolio();
    }

    public function index()
	{
		redirect(base_url());
	}

	public function view($id=0)
	{
		if( !isset($id) || !is_numeric($id) ) {
			redirect(base_url());
		}

		$tot = $this->Model_team_member->team_member_check($id);
		if(!$tot) {
			redirect(base_url());
		}

		$data['setting'] = $this->Model_common->all_setting();
		$data['page_team'] = $this->Model_common->all_page_team();
		$data['comment'] = $this->Model_common->all_comment();
		$data['social'] = $this->Model_common->all_social();
		$data['all_news'] = $this->Model_common->all_news();

		$data['team_members'] = $this->Model_team_member->all_team_member();
		$data['member'] = $this->Model_team_member->team_member_detail($id);

		$data['portfolio_footer'] = $this->Model_portfolio->get_portfolio_data();

		$data['id'] = $id;

		echo view('view_header',$data);
		echo view('view_team_member',$data);
		echo view('view_footer');
	}
}