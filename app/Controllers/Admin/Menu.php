<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Menu extends BaseController
{
    private const DEFAULT_LANG_ID = 5;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('nav_menu');
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_nav_menu = new \App\Models\Admin\Model_nav_menu();
    }

    public function index()
    {
        $data['setting'] = $this->Model_common->get_setting_data();
        $data['nav_menu'] = $this->Model_nav_menu->show(self::DEFAULT_LANG_ID);

        echo view('admin/view_header', $data);
        echo view('admin/view_nav_menu', $data);
        echo view('admin/view_footer');
    }

    public function add()
    {
        $data['setting'] = $this->Model_common->get_setting_data();
        $data['page_options'] = nav_menu_page_options();
        $data['parent_options'] = $this->Model_nav_menu->parent_options(self::DEFAULT_LANG_ID);
        $error = '';

        if (isset($_POST['form1'])) {
            if (PROJECT_MODE == 0) {
                $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
                redirect($_SERVER['HTTP_REFERER']);
            }

            $valid = 1;
            $this->form_validation->set_rules('label', 'Label', 'trim|required');

            if ($this->form_validation->run() === false) {
                $valid = 0;
                $error .= validation_errors();
            }

            $linkType = $this->request->getPost('link_type', true) ?: 'page';
            if ($linkType === 'page' && $this->request->getPost('slug', true) === '' && empty($_POST['children_only'])) {
                // allow empty slug only for none type
            }
            if ($linkType === 'url' && trim($this->request->getPost('custom_url', true) ?? '') === '') {
                $valid = 0;
                $error .= 'Custom URL is required for URL link type.<br>';
            }

            if ($valid === 1) {
                $this->Model_nav_menu->add($this->buildFormData());
                $this->session->setFlashdata('success', 'Menu item added successfully.');
                redirect(base_url('admin/menu'));
            }

            $this->session->setFlashdata('error', $error);
            redirect(base_url('admin/menu/add'));
        }

        echo view('admin/view_header', $data);
        echo view('admin/view_nav_menu_add', $data);
        echo view('admin/view_footer');
    }

    public function edit($id)
    {
        $row = $this->Model_nav_menu->nav_menu_check((int) $id);
        if (! $row) {
            redirect(base_url('admin/menu'));
            exit;
        }

        $data['setting'] = $this->Model_common->get_setting_data();
        $data['nav_menu'] = $row;
        $data['page_options'] = nav_menu_page_options();
        $data['parent_options'] = $this->Model_nav_menu->parent_options(self::DEFAULT_LANG_ID, (int) $id);
        $error = '';

        if (isset($_POST['form1'])) {
            if (PROJECT_MODE == 0) {
                $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
                redirect($_SERVER['HTTP_REFERER']);
            }

            $valid = 1;
            $this->form_validation->set_rules('label', 'Label', 'trim|required');

            if ($this->form_validation->run() === false) {
                $valid = 0;
                $error .= validation_errors();
            }

            $parentId = (int) ($this->request->getPost('parent_id') ?? 0);
            if ($parentId === (int) $id) {
                $valid = 0;
                $error .= 'A menu item cannot be its own parent.<br>';
            }

            $linkType = $this->request->getPost('link_type', true) ?: 'page';
            if ($linkType === 'url' && trim($this->request->getPost('custom_url', true) ?? '') === '') {
                $valid = 0;
                $error .= 'Custom URL is required for URL link type.<br>';
            }

            if ($valid === 1) {
                $this->Model_nav_menu->update((int) $id, $this->buildFormData());
                $this->session->setFlashdata('success', 'Menu item updated successfully.');
                redirect(base_url('admin/menu'));
            }

            $this->session->setFlashdata('error', $error);
            redirect(base_url('admin/menu/edit/' . $id));
        }

        echo view('admin/view_header', $data);
        echo view('admin/view_nav_menu_edit', $data);
        echo view('admin/view_footer');
    }

    public function delete($id)
    {
        $row = $this->Model_nav_menu->nav_menu_check((int) $id);
        if (! $row) {
            redirect(base_url('admin/menu'));
            exit;
        }

        if (PROJECT_MODE == 0) {
            $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
            redirect($_SERVER['HTTP_REFERER']);
        }

        if ($this->Model_nav_menu->child_count((int) $id) > 0) {
            $this->session->setFlashdata('error', 'Delete child menu items first.');
            redirect(base_url('admin/menu'));
        }

        $this->Model_nav_menu->delete((int) $id);
        $this->session->setFlashdata('success', 'Menu item deleted successfully.');
        redirect(base_url('admin/menu'));
    }

    private function buildFormData(): array
    {
        $linkType = $this->request->getPost('link_type', true) ?: 'page';

        return [
            'parent_id'        => (int) ($this->request->getPost('parent_id') ?? 0),
            'lang_id'          => self::DEFAULT_LANG_ID,
            'label'            => $this->request->getPost('label', true),
            'link_type'        => $linkType,
            'slug'             => $linkType === 'page' ? $this->request->getPost('slug', true) : null,
            'custom_url'       => $linkType === 'url' ? $this->request->getPost('custom_url', true) : null,
            'sort_order'       => (int) ($this->request->getPost('sort_order') ?? 0),
            'menu_status'      => $this->request->getPost('menu_status', true) === 'Hide' ? 'Hide' : 'Show',
            'meta_title'       => $this->request->getPost('meta_title', true),
            'meta_keyword'     => $this->request->getPost('meta_keyword', true),
            'meta_description' => $this->request->getPost('meta_description', true),
        ];
    }
}
