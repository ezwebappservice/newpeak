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
            'event_date'    => $workshop->eventDate,
            'event_time'    => $workshop->eventTime,
            'event_format'  => $workshop->eventFormat,
            'zoom_link'     => $workshop->zoomLink,
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

    public function update_details()
    {
        if (! $this->request->is('post')) {
            return redirect()->to(base_url('admin/workshop_registration'));
        }

        if (defined('PROJECT_MODE') && PROJECT_MODE == 0) {
            $this->session->setFlashdata('error', PROJECT_NOTIFICATION);

            return redirect()->to(base_url('admin/workshop_registration'));
        }

        $date = trim(strip_tags((string) $this->request->getPost('event_date')));
        $time = trim(strip_tags((string) $this->request->getPost('event_time')));
        $format = trim(strip_tags((string) $this->request->getPost('event_format')));
        $zoom = trim((string) $this->request->getPost('zoom_link'));

        if ($date === '' || mb_strlen($date) > 80) {
            $this->session->setFlashdata('error', 'Enter a workshop date of up to 80 characters.');

            return redirect()->to(base_url('admin/workshop_registration'));
        }

        if ($time === '' || mb_strlen($time) > 80) {
            $this->session->setFlashdata('error', 'Enter a workshop time of up to 80 characters.');

            return redirect()->to(base_url('admin/workshop_registration'));
        }

        if ($format === '' || mb_strlen($format) > 120) {
            $this->session->setFlashdata('error', 'Enter a workshop format of up to 120 characters.');

            return redirect()->to(base_url('admin/workshop_registration'));
        }

        $workshop = config(\Config\Workshop::class);

        if ($zoom !== '' && (mb_strlen($zoom) > 500 || ! $workshop->isHttpUrl($zoom))) {
            $this->session->setFlashdata('error', 'Zoom link must be a valid http or https URL, or leave it blank.');

            return redirect()->to(base_url('admin/workshop_registration'));
        }

        $db = \Config\Database::connect();
        $required = ['workshop_event_date', 'workshop_event_time', 'workshop_event_format', 'workshop_zoom_link'];

        foreach ($required as $column) {
            if (! $db->tableExists('tbl_settings') || ! $db->fieldExists($column, 'tbl_settings')) {
                $this->session->setFlashdata('error', 'The workshop schedule settings are not available yet. Run the latest database migration.');

                return redirect()->to(base_url('admin/workshop_registration'));
            }
        }

        (new \App\Models\Admin\Model_setting())->update([
            'workshop_event_date'   => $date,
            'workshop_event_time'   => $time,
            'workshop_event_format' => $format,
            'workshop_zoom_link'    => $zoom !== '' ? $zoom : null,
        ]);

        $this->session->setFlashdata('success', 'Workshop date, time, and format updated. The registration page will use these details.');

        return redirect()->to(base_url('admin/workshop_registration'));
    }
}
