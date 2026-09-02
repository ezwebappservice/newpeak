<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Dashboard extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_dashboard = new \App\Models\Admin\Model_dashboard();
    }

    public function index()
    {
        $newInquiries = $this->Model_dashboard->show_new_site_inquiry();

        $data = [
            'setting'        => $this->Model_common->get_setting_data(),
            'stats'          => [
                [
                    'label' => 'Enquiries',
                    'value' => $this->Model_dashboard->show_total_site_inquiry(),
                    'note'  => $newInquiries > 0 ? $newInquiries . ' new' : '',
                    'icon'  => 'fa-envelope',
                    'color' => 'bg-yellow',
                    'url'   => 'admin/site_inquiry',
                ]
            ],
        ];

        echo view('admin/view_header', $data);
        echo view('admin/view_dashboard', $data);
        echo view('admin/view_footer');
    }
}
