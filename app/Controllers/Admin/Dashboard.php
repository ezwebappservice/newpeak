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
                    'label' => 'News Articles',
                    'value' => $this->Model_dashboard->show_total_news(),
                    'icon'  => 'fa-newspaper-o',
                    'color' => 'bg-aqua',
                    'url'   => 'admin/news',
                ],
                [
                    'label' => 'Leadership Team',
                    'value' => $this->Model_dashboard->show_total_team_member(),
                    'icon'  => 'fa-users',
                    'color' => 'bg-green',
                    'url'   => 'admin/team_member',
                ],
                [
                    'label' => 'Career Openings',
                    'value' => $this->Model_dashboard->show_total_career(),
                    'icon'  => 'fa-briefcase',
                    'color' => 'bg-teal',
                    'url'   => 'admin/career',
                ],
                [
                    'label' => 'Dynamic Pages',
                    'value' => $this->Model_dashboard->show_total_dynamic_page(),
                    'icon'  => 'fa-files-o',
                    'color' => 'bg-purple',
                    'url'   => 'admin/page-dynamic',
                ],
                [
                    'label' => 'API Products',
                    'value' => $this->Model_dashboard->show_total_api_product(),
                    'icon'  => 'fa-medkit',
                    'color' => 'bg-blue',
                    'url'   => 'admin/api_product_oncology',
                ],
                [
                    'label' => 'Investor Documents',
                    'value' => $this->Model_dashboard->show_total_investor_document(),
                    'icon'  => 'fa-line-chart',
                    'color' => 'bg-navy',
                    'url'   => 'admin/investor_document',
                ],
                [
                    'label' => 'Form Inquiries',
                    'value' => $this->Model_dashboard->show_total_site_inquiry(),
                    'note'  => $newInquiries > 0 ? $newInquiries . ' new' : '',
                    'icon'  => 'fa-envelope',
                    'color' => 'bg-yellow',
                    'url'   => 'admin/site_inquiry',
                ],
                [
                    'label' => 'Newsletter Subscribers',
                    'value' => $this->Model_dashboard->show_total_subscriber(),
                    'icon'  => 'fa-paper-plane',
                    'color' => 'bg-orange',
                    'url'   => 'admin/subscriber',
                ],
            ],
        ];

        echo view('admin/view_header', $data);
        echo view('admin/view_dashboard', $data);
        echo view('admin/view_footer');
    }
}
