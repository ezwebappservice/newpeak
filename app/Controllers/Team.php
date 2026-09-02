<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Team extends MY_Controller
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Model_common();
        $this->Model_team = new \App\Models\Model_team();
        $this->Model_portfolio = new \App\Models\Model_portfolio();
    }

    /**
     * Live site URL: /leadership-at-srl/
     */
    public function leadership()
    {
        $pageTeam = $this->Model_common->all_page_team();

        $data['setting'] = $this->Model_common->all_setting();
        $data['page_team'] = $pageTeam;
        $data['comment'] = $this->Model_common->all_comment();
        $data['social'] = $this->Model_common->all_social();
        $data['all_news'] = $this->Model_common->all_news();
        $data['team_members'] = $this->Model_team->all_team_member();
        $data['portfolio_footer'] = $this->Model_portfolio->get_portfolio_data();
        $data['meta_title'] = $pageTeam['mt_team'] ?? 'Leadership Team | Shivalik Rasayan Limited';
        $data['meta_description'] = $pageTeam['md_team'] ?? '';
        $data['meta_keywords'] = $pageTeam['mk_team'] ?? '';
        $GLOBALS['theme_current_page_slug'] = 'leadership-at-srl';

        echo view('view_header', $data);
        echo view('view_leadership', $data);
        echo view('view_footer', $data);
    }

    /** Generic team listing (legacy /team URL) */
    public function index()
    {
        return $this->leadership();
    }
}
