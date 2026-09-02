<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Site_inquiry extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('site_inquiry');
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_site_inquiry = new \App\Models\Admin\Model_site_inquiry();
    }

    public function index()
    {
        $source = trim((string) ($this->request->getGet('source') ?? ''));
        $status = trim((string) ($this->request->getGet('status') ?? ''));

        $data = [
            'setting'   => $this->Model_common->get_setting_data(),
            'inquiries' => $this->Model_site_inquiry->show($source ?: null, $status ?: null),
            'filter_source' => $source,
            'filter_status' => $status,
            'new_count' => $this->Model_site_inquiry->count_new(),
        ];

        echo view('admin/view_header', $data);
        echo view('admin/view_site_inquiry', $data);
        echo view('admin/view_footer');
    }

    public function view($id = 0)
    {
        $row = $this->Model_site_inquiry->get((int) $id);

        if (! $row) {
            redirect(base_url('admin/site_inquiry'));
        }

        if (($row['status'] ?? '') === 'New') {
            $this->Model_site_inquiry->mark_read((int) $id);
            $row['status'] = 'Read';
        }

        $data = [
            'setting' => $this->Model_common->get_setting_data(),
            'inquiry' => $row,
        ];

        echo view('admin/view_header', $data);
        echo view('admin/view_site_inquiry_detail', $data);
        echo view('admin/view_footer');
    }

    public function delete($id = 0)
    {
        $row = $this->Model_site_inquiry->get((int) $id);

        if (! $row) {
            redirect(base_url('admin/site_inquiry'));
        }

        if (PROJECT_MODE == 0) {
            $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
            redirect(base_url('admin/site_inquiry'));
        }

        $this->Model_site_inquiry->delete((int) $id);
        $this->session->setFlashdata('success', 'Inquiry deleted successfully.');
        redirect(base_url('admin/site_inquiry'));
    }
}
