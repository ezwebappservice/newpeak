<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Career extends BaseController
{
    protected \App\Models\Admin\Model_career $Model_career;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_career = new \App\Models\Admin\Model_career();
    }

    public function index()
    {
        $data['setting'] = $this->Model_common->get_setting_data();
        $data['careers'] = $this->Model_career->show();

        echo view('admin/view_header', $data);
        echo view('admin/view_career', $data);
        echo view('admin/view_footer');
    }

    public function add()
    {
        $data['setting'] = $this->Model_common->get_setting_data();
        $data['next_sort_order'] = $this->Model_career->next_sort_order();

        if (isset($_POST['form1'])) {
            if (PROJECT_MODE == 0) {
                $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
                redirect($_SERVER['HTTP_REFERER']);
            }

            $valid = 1;
            $error = '';

            $this->form_validation->set_rules('job_title', 'Job Title', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('job_description', 'Job Description', 'trim|required');

            if ($this->form_validation->run() == false) {
                $valid = 0;
                $error .= validation_errors();
            }

            if ($valid === 1) {
                $now = date('Y-m-d H:i:s');
                $this->Model_career->add([
                    'job_title'         => trim((string) $this->request->getPost('job_title', true)),
                    'department'        => trim((string) $this->request->getPost('department', true)) ?: null,
                    'location'          => trim((string) $this->request->getPost('location', true)) ?: null,
                    'job_type'          => trim((string) $this->request->getPost('job_type', true)) ?: null,
                    'experience'        => trim((string) $this->request->getPost('experience', true)) ?: null,
                    'short_description' => trim((string) $this->request->getPost('short_description', true)) ?: null,
                    'job_description'   => trim((string) $this->request->getPost('job_description', true)),
                    'requirements'      => trim((string) $this->request->getPost('requirements', true)) ?: null,
                    'apply_email'       => trim((string) $this->request->getPost('apply_email', true)) ?: null,
                    'sort_order'        => (int) ($this->request->getPost('sort_order') ?? 0),
                    'status'            => $this->request->getPost('status', true) === 'Inactive' ? 'Inactive' : 'Active',
                    'lang_id'           => 5,
                    'created_at'        => $now,
                    'updated_at'        => $now,
                ]);

                $this->session->setFlashdata('success', 'Job opening added successfully!');
                redirect(base_url('admin/career'));
            }

            $this->session->setFlashdata('error', $error);
            redirect(base_url('admin/career/add'));
        }

        echo view('admin/view_header', $data);
        echo view('admin/view_career_add', $data);
        echo view('admin/view_footer');
    }

    public function edit($id = 0)
    {
        if (! is_numeric($id)) {
            redirect(base_url('admin/career'));
        }

        $career = $this->Model_career->career_check((int) $id);

        if (! $career) {
            redirect(base_url('admin/career'));
        }

        $data['setting'] = $this->Model_common->get_setting_data();
        $data['career'] = $career;

        if (isset($_POST['form1'])) {
            if (PROJECT_MODE == 0) {
                $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
                redirect($_SERVER['HTTP_REFERER']);
            }

            $valid = 1;
            $error = '';

            $this->form_validation->set_rules('job_title', 'Job Title', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('job_description', 'Job Description', 'trim|required');

            if ($this->form_validation->run() == false) {
                $valid = 0;
                $error .= validation_errors();
            }

            if ($valid === 1) {
                $this->Model_career->update((int) $id, [
                    'job_title'         => trim((string) $this->request->getPost('job_title', true)),
                    'department'        => trim((string) $this->request->getPost('department', true)) ?: null,
                    'location'          => trim((string) $this->request->getPost('location', true)) ?: null,
                    'job_type'          => trim((string) $this->request->getPost('job_type', true)) ?: null,
                    'experience'        => trim((string) $this->request->getPost('experience', true)) ?: null,
                    'short_description' => trim((string) $this->request->getPost('short_description', true)) ?: null,
                    'job_description'   => trim((string) $this->request->getPost('job_description', true)),
                    'requirements'      => trim((string) $this->request->getPost('requirements', true)) ?: null,
                    'apply_email'       => trim((string) $this->request->getPost('apply_email', true)) ?: null,
                    'sort_order'        => (int) ($this->request->getPost('sort_order') ?? 0),
                    'status'            => $this->request->getPost('status', true) === 'Inactive' ? 'Inactive' : 'Active',
                    'lang_id'           => 5,
                    'updated_at'        => date('Y-m-d H:i:s'),
                ]);

                $this->session->setFlashdata('success', 'Job opening updated successfully!');
                redirect(base_url('admin/career'));
            }

            $this->session->setFlashdata('error', $error);
            redirect(base_url('admin/career/edit/' . $id));
        }

        echo view('admin/view_header', $data);
        echo view('admin/view_career_edit', $data);
        echo view('admin/view_footer');
    }

    public function delete($id = 0)
    {
        if (! is_numeric($id)) {
            redirect(base_url('admin/career'));
        }

        if (PROJECT_MODE == 0) {
            $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
            redirect(base_url('admin/career'));
        }

        $career = $this->Model_career->career_check((int) $id);

        if (! $career) {
            redirect(base_url('admin/career'));
        }

        $this->Model_career->delete((int) $id);
        $this->session->setFlashdata('success', 'Job opening deleted successfully!');
        redirect(base_url('admin/career'));
    }
}
