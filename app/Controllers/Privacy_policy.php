<?php
namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Privacy_policy extends MY_Controller
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Model_common();
    }

    public function index()
    {
        $this->render_frontend('view_privacy_policy', [
            'current_page'     => 'privacy-policy',
            'page_privacy'     => $this->safe_cms_page('all_page_privacy'),
            'meta_title'       => 'Privacy Policy | Peak Potential Academy',
            'meta_description' => 'How Peak Potential Academy collects, uses and protects your information.',
        ]);
    }
}
