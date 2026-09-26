<?php
namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class About extends MY_Controller
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Model_common();
        $this->Model_portfolio = new \App\Models\Model_portfolio();
    }

    public function index()
    {
        $this->render_frontend('view_our_story', [
            'current_page'     => 'our-story',
            'meta_title'       => 'Parenting Unplugged | Peak Potential Academy',
            'meta_description' => 'A live online workshop for parents of 13+ year olds. 4th October 2026, 11:00 AM–12:00 PM IST, on Zoom.',
            'page_about'       => $this->safe_cms_page('all_page_about'),
        ]);
    }
}
