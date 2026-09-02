<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Page extends MY_Controller
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Model_common();
        $this->Model_portfolio = new \App\Models\Model_portfolio();
        $this->Model_page = new \App\Models\Model_page();
    }

    public function index($slug = '')
    {
        $slug = trim($slug, '/');

        if ($slug === '') {
            throw PageNotFoundException::forPageNotFound();
        }

        $page = $this->Model_page->dynamic_page_by_slug($slug);

        if (! $page) {
            throw PageNotFoundException::forPageNotFound();
        }

        $data['setting'] = $this->Model_common->all_setting();
        $data['page_about'] = $this->Model_common->all_page_about();
        $data['comment'] = $this->Model_common->all_comment();
        $data['social'] = $this->Model_common->all_social();
        $data['all_news'] = $this->Model_common->all_news();
        $data['portfolio_footer'] = $this->Model_portfolio->get_portfolio_data();
        $data['page_dynamic_detail'] = $page;
        $data['current_page_slug'] = $slug;
        $GLOBALS['theme_current_page_slug'] = $slug;

        echo view('view_header', $data);

        if ($slug === 'careers') {
            $this->Model_career = new \App\Models\Model_career();
            $data['careers'] = $this->Model_career->active_jobs();
            echo view('view_careers', $data);
        } else {
            echo view('view_page_dynamic', $data);
        }

        echo view('view_footer', $data);
    }
}
