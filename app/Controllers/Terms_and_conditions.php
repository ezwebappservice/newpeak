<?php
namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Terms_and_conditions extends MY_Controller
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Model_common();
    }

    public function index()
    {
        $this->render_frontend('view_term_and_condition', [
            'current_page'     => 'terms',
            'page_term'        => $this->safe_cms_page('all_page_term'),
            'meta_title'       => 'Terms & Conditions | Peak Potential Academy',
            'meta_description' => 'Please read these terms carefully before using the Peak Potential Academy website or services.',
        ]);
    }
}
