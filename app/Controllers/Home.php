<?php
namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Home extends MY_Controller
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Model_common();
    }

    public function index()
    {
        $this->render_frontend('view_home', [
            'current_page'     => 'home',
            'meta_title'       => 'Peak Potential Academy',
            'meta_description' => 'Break the invisible loops holding you back. Peak Potential Academy helps students, parents, schools and organisations build emotional strength and life skills.',
        ]);
    }

    public function send_email()
    {
        return redirect()->to(base_url('contact-us'));
    }
}
