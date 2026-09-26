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

        $data = [
            'setting'       => $settings->get_setting_data(),
            'registrations' => $model->all($status !== '' ? $status : null),
            'filter_status' => $status,
            'paid_count'    => $model->countPaid(),
        ];

        echo view('admin/view_header', $data);
        echo view('admin/view_workshop_registration', $data);
        echo view('admin/view_footer');
    }
}
