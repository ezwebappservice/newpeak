<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Workshop_registration extends BaseController
{
    public function index()
    {
        $status = trim((string) ($this->request->getGet('status') ?? ''));
        $model = new \App\Models\Model_workshop_registration();
        $settings = new \App\Models\Admin\Model_common();

        $workshop = config(\Config\Workshop::class);

        $data = [
            'setting'       => $settings->get_setting_data(),
            'registrations' => $model->all($status !== '' ? $status : null),
            'filter_status' => $status,
            'paid_count'    => $model->countPaid(),
            'seat_fee'      => $workshop->amountInr,
        ];

        echo view('admin/view_header', $data);
        echo view('admin/view_workshop_registration', $data);
        echo view('admin/view_footer');
    }

    public function update_price()
    {
        if (! $this->request->is('post')) {
            return redirect()->to(base_url('admin/workshop_registration'));
        }

        if (defined('PROJECT_MODE') && PROJECT_MODE == 0) {
            $this->session->setFlashdata('error', PROJECT_NOTIFICATION);

            return redirect()->to(base_url('admin/workshop_registration'));
        }

        $amount = (int) $this->request->getPost('seat_fee');

        if ($amount < 1 || $amount > 1000000) {
            $this->session->setFlashdata('error', 'Enter a seat fee between ₹1 and ₹10,00,000.');

            return redirect()->to(base_url('admin/workshop_registration'));
        }

        $db = \Config\Database::connect();

        if (! $db->tableExists('tbl_settings') || ! $db->fieldExists('workshop_seat_fee', 'tbl_settings')) {
            $this->session->setFlashdata('error', 'The seat fee setting is not available yet. Run the latest database migration.');

            return redirect()->to(base_url('admin/workshop_registration'));
        }

        (new \App\Models\Admin\Model_setting())->update([
            'workshop_seat_fee' => $amount,
        ]);

        $this->session->setFlashdata('success', 'Seat fee updated to ₹' . number_format($amount) . '. The registration page will use this price.');

        return redirect()->to(base_url('admin/workshop_registration'));
    }
}
