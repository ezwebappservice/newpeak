<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Investor_category extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('investor');
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_investor_category = new \App\Models\Admin\Model_investor_category();
    }

    public function index()
    {
        $search = trim((string) ($this->request->getGet('search') ?? ''));
        $sort = (string) ($this->request->getGet('sort') ?? 'sort_order');
        $order = (string) ($this->request->getGet('order') ?? 'asc');

        $data['setting'] = $this->Model_common->get_setting_data();
        $data['search'] = $search;
        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['investor_categories'] = $this->Model_investor_category->show($search, $sort, $order);

        echo view('admin/view_header', $data);
        echo view('admin/view_investor_category', $data);
        echo view('admin/view_footer');
    }

    public function add()
    {
        $data['setting'] = $this->Model_common->get_setting_data();
        $data['parent_categories'] = $this->Model_investor_category->parent_options();
        $data['next_sort_order'] = $this->Model_investor_category->next_sort_order();

        if (isset($_POST['form1'])) {
            if (PROJECT_MODE == 0) {
                $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
                redirect($_SERVER['HTTP_REFERER']);
            }

            $valid = 1;
            $error = '';
            $categoryName = trim((string) $this->request->getPost('category_name', true));
            $status = $this->request->getPost('status', true) === 'Inactive' ? 'Inactive' : 'Active';
            $parentId = (int) $this->request->getPost('parent_id', true);
            $parentId = $parentId > 0 ? $parentId : null;
            $sortOrder = max(0, (int) $this->request->getPost('sort_order', true));

            $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|required|integer');

            if ($this->form_validation->run() == false) {
                $valid = 0;
                $error .= validation_errors();
            }

            if ($valid && $sortOrder === 0 && $this->request->getPost('sort_order', true) === '') {
                $sortOrder = $this->Model_investor_category->next_sort_order($parentId);
            }

            if ($valid && $this->Model_investor_category->name_exists($categoryName)) {
                $valid = 0;
                $error .= 'This category name already exists.<br>';
            }

            if ($valid && ! $this->Model_investor_category->is_valid_parent($parentId)) {
                $valid = 0;
                $error .= 'Selected parent category is invalid. Only top-level categories can be parents.<br>';
            }

            if ($valid == 1) {
                $now = date('Y-m-d H:i:s');
                $slug = trim((string) $this->request->getPost('category_slug', true));
                $slug = $slug !== '' ? url_title($slug, '-', true) : investor_make_category_slug($categoryName);

                $this->Model_investor_category->add([
                    'category_name' => $categoryName,
                    'category_slug' => $slug,
                    'parent_id'     => $parentId,
                    'sort_order'    => $sortOrder,
                    'status'        => $status,
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ]);

                $this->session->setFlashdata('success', 'Investor category added successfully!');
                redirect(base_url() . 'admin/investor_category');
            }

            $this->session->setFlashdata('error', $error);
            redirect(base_url() . 'admin/investor_category/add');
        }

        echo view('admin/view_header', $data);
        echo view('admin/view_investor_category_add', $data);
        echo view('admin/view_footer');
    }

    public function edit($id = 0)
    {
        if (! is_numeric($id)) {
            redirect(base_url() . 'admin/investor_category');
        }

        $row = $this->Model_investor_category->investor_category_check($id);

        if (! $row) {
            redirect(base_url() . 'admin/investor_category');
        }

        $data['setting'] = $this->Model_common->get_setting_data();
        $data['investor_category'] = $row;
        $data['parent_categories'] = $this->Model_investor_category->parent_options((int) $id);
        $data['has_children'] = $this->Model_investor_category->child_count((int) $id) > 0;
        $error = '';

        if (isset($_POST['form1'])) {
            if (PROJECT_MODE == 0) {
                $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
                redirect($_SERVER['HTTP_REFERER']);
            }

            $valid = 1;
            $categoryName = trim((string) $this->request->getPost('category_name', true));
            $status = $this->request->getPost('status', true) === 'Inactive' ? 'Inactive' : 'Active';
            $parentId = (int) $this->request->getPost('parent_id', true);
            $parentId = $parentId > 0 ? $parentId : null;
            $sortOrder = max(0, (int) $this->request->getPost('sort_order', true));

            $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|required|integer');

            if ($this->form_validation->run() == false) {
                $valid = 0;
                $error .= validation_errors();
            }

            if ($valid && $this->Model_investor_category->name_exists($categoryName, (int) $id)) {
                $valid = 0;
                $error .= 'This category name already exists.<br>';
            }

            if ($valid && $this->Model_investor_category->child_count((int) $id) > 0 && $parentId !== null) {
                $valid = 0;
                $error .= 'Parent categories with sub-categories cannot be assigned under another parent.<br>';
            }

            if ($valid && ! $this->Model_investor_category->is_valid_parent($parentId, (int) $id)) {
                $valid = 0;
                $error .= 'Selected parent category is invalid.<br>';
            }

            if ($valid == 1) {
                $slug = trim((string) $this->request->getPost('category_slug', true));
                $slug = $slug !== '' ? url_title($slug, '-', true) : investor_make_category_slug($categoryName, (int) $id);

                $this->Model_investor_category->update($id, [
                    'category_name' => $categoryName,
                    'category_slug' => $slug,
                    'parent_id'     => $parentId,
                    'sort_order'    => $sortOrder,
                    'status'        => $status,
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]);

                $this->session->setFlashdata('success', 'Investor category updated successfully!');
                redirect(base_url() . 'admin/investor_category');
            }

            $this->session->setFlashdata('error', $error);
            redirect(base_url() . 'admin/investor_category/edit/' . $id);
        }

        echo view('admin/view_header', $data);
        echo view('admin/view_investor_category_edit', $data);
        echo view('admin/view_footer');
    }

    public function delete($id = 0)
    {
        if (! is_numeric($id)) {
            redirect(base_url() . 'admin/investor_category');
        }

        if (PROJECT_MODE == 0) {
            $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
            redirect(base_url() . 'admin/investor_category');
        }

        $row = $this->Model_investor_category->investor_category_check($id);

        if (! $row) {
            redirect(base_url() . 'admin/investor_category');
        }

        $docCount = $this->Model_investor_category->document_count($id);
        $childCount = $this->Model_investor_category->child_count((int) $id);

        if ($childCount > 0) {
            $this->session->setFlashdata('error', 'Cannot delete a parent category while sub-categories exist.');
            redirect(base_url() . 'admin/investor_category');
        }

        if ($docCount > 0) {
            $this->session->setFlashdata('error', 'Cannot delete category with existing documents. Remove documents first.');
            redirect(base_url() . 'admin/investor_category');
        }

        $this->Model_investor_category->delete($id);
        $this->session->setFlashdata('success', 'Investor category deleted successfully!');
        redirect(base_url() . 'admin/investor_category');
    }
}
