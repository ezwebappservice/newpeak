<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Certification extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_certification = new \App\Models\Admin\Model_certification();
    }

    public function index()
    {
        $data['setting'] = $this->Model_common->get_setting_data();
        $data['certification'] = $this->Model_certification->show();

        echo view('admin/view_header', $data);
        echo view('admin/view_certification', $data);
        echo view('admin/view_footer');
    }

    public function add()
    {
        $data['setting'] = $this->Model_common->get_setting_data();
        $data['all_lang'] = $this->Model_common->all_lang();
        $error = '';
        $success = '';

        if (isset($_POST['form1'])) {
            if (PROJECT_MODE == 0) {
                $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
                redirect($_SERVER['HTTP_REFERER']);
            }

            $valid = 1;
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            $this->form_validation->set_rules('icon', 'Icon', 'trim|required');

            if ($this->form_validation->run() == false) {
                $valid = 0;
                $error .= validation_errors();
            }

            if ($valid == 1) {
                $this->Model_certification->add([
                    'name'        => $_POST['name'],
                    'description' => $_POST['description'],
                    'icon'        => $_POST['icon'],
                    'sort_order'  => (int) ($_POST['sort_order'] ?? 0),
                    'lang_id'     => $_POST['lang_id'],
                ]);

                $this->session->setFlashdata('success', 'Certification is added successfully!');
                redirect(base_url() . 'admin/certification');
            }

            $this->session->setFlashdata('error', $error);
            redirect(base_url() . 'admin/certification/add');
        }

        echo view('admin/view_header', $data);
        echo view('admin/view_certification_add', $data);
        echo view('admin/view_footer');
    }

    public function edit($id)
    {
        $tot = $this->Model_certification->certification_check($id);
        if (! $tot) {
            redirect(base_url() . 'admin/certification');
            exit;
        }

        $data['setting'] = $this->Model_common->get_setting_data();
        $data['all_lang'] = $this->Model_common->all_lang();
        $error = '';

        if (isset($_POST['form1'])) {
            if (PROJECT_MODE == 0) {
                $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
                redirect($_SERVER['HTTP_REFERER']);
            }

            $valid = 1;
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            $this->form_validation->set_rules('icon', 'Icon', 'trim|required');

            if ($this->form_validation->run() == false) {
                $valid = 0;
                $error .= validation_errors();
            }

            if ($valid == 1) {
                $this->Model_certification->update($id, [
                    'name'        => $_POST['name'],
                    'description' => $_POST['description'],
                    'icon'        => $_POST['icon'],
                    'sort_order'  => (int) ($_POST['sort_order'] ?? 0),
                    'lang_id'     => $_POST['lang_id'],
                ]);

                $this->session->setFlashdata('success', 'Certification is updated successfully');
                redirect(base_url() . 'admin/certification');
            }

            $this->session->setFlashdata('error', $error);
            redirect(base_url() . 'admin/certification/edit/' . $id);
        }

        $data['certification'] = $this->Model_certification->getData($id);
        echo view('admin/view_header', $data);
        echo view('admin/view_certification_edit', $data);
        echo view('admin/view_footer');
    }

    public function delete($id)
    {
        $tot = $this->Model_certification->certification_check($id);
        if (! $tot) {
            redirect(base_url() . 'admin/certification');
            exit;
        }

        if (PROJECT_MODE == 0) {
            $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->Model_certification->delete($id);
        $this->session->setFlashdata('success', 'Certification is deleted successfully');
        redirect(base_url() . 'admin/certification');
    }
}
