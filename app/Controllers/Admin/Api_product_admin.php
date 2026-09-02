<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class Api_product_admin extends BaseController
{
    protected string $productType = '';
    protected string $moduleTitle = '';
    protected string $basePath = '';

    protected \App\Models\Admin\Model_api_product $Model_api_product;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_api_product = new \App\Models\Admin\Model_api_product();
    }

    public function index()
    {
        $data = $this->moduleData([
            'products' => $this->Model_api_product->show($this->productType),
        ]);

        echo view('admin/view_header', $data);
        echo view('admin/view_api_product', $data);
        echo view('admin/view_footer');
    }

    public function add()
    {
        $data = $this->moduleData([
            'next_sort_order' => $this->Model_api_product->next_sort_order($this->productType),
        ]);

        if (isset($_POST['form1'])) {
            if (PROJECT_MODE == 0) {
                $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
                redirect($_SERVER['HTTP_REFERER']);
            }

            $valid = 1;
            $error = '';

            $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|max_length[255]');

            if ($this->form_validation->run() == false) {
                $valid = 0;
                $error .= validation_errors();
            }

            if ($valid === 1) {
                $now = date('Y-m-d H:i:s');
                $this->Model_api_product->add([
                    'product_type'         => $this->productType,
                    'product_name'         => trim((string) $this->request->getPost('product_name', true)),
                    'therapeutic_category' => trim((string) $this->request->getPost('therapeutic_category', true)) ?: null,
                    'us_dmf'               => trim((string) $this->request->getPost('us_dmf', true)) ?: null,
                    'eu_status'            => trim((string) $this->request->getPost('eu_status', true)) ?: null,
                    'patent_status'        => trim((string) $this->request->getPost('patent_status', true)) ?: null,
                    'remarks'              => trim((string) $this->request->getPost('remarks', true)) ?: null,
                    'sort_order'           => (int) ($this->request->getPost('sort_order') ?? 0),
                    'status'               => $this->request->getPost('status', true) === 'Inactive' ? 'Inactive' : 'Active',
                    'lang_id'              => 5,
                    'created_at'           => $now,
                    'updated_at'           => $now,
                ]);

                $this->session->setFlashdata('success', 'Product added successfully!');
                redirect(base_url() . $this->basePath);
            }

            $this->session->setFlashdata('error', $error);
            redirect(base_url() . $this->basePath . '/add');
        }

        echo view('admin/view_header', $data);
        echo view('admin/view_api_product_add', $data);
        echo view('admin/view_footer');
    }

    public function edit($id = 0)
    {
        if (! is_numeric($id)) {
            redirect(base_url() . $this->basePath);
        }

        $product = $this->Model_api_product->product_check((int) $id, $this->productType);

        if (! $product) {
            redirect(base_url() . $this->basePath);
        }

        $data = $this->moduleData(['product' => $product]);

        if (isset($_POST['form1'])) {
            if (PROJECT_MODE == 0) {
                $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
                redirect($_SERVER['HTTP_REFERER']);
            }

            $valid = 1;
            $error = '';

            $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|max_length[255]');

            if ($this->form_validation->run() == false) {
                $valid = 0;
                $error .= validation_errors();
            }

            if ($valid === 1) {
                $this->Model_api_product->update((int) $id, [
                    'product_name'         => trim((string) $this->request->getPost('product_name', true)),
                    'therapeutic_category' => trim((string) $this->request->getPost('therapeutic_category', true)) ?: null,
                    'us_dmf'               => trim((string) $this->request->getPost('us_dmf', true)) ?: null,
                    'eu_status'            => trim((string) $this->request->getPost('eu_status', true)) ?: null,
                    'patent_status'        => trim((string) $this->request->getPost('patent_status', true)) ?: null,
                    'remarks'              => trim((string) $this->request->getPost('remarks', true)) ?: null,
                    'sort_order'           => (int) ($this->request->getPost('sort_order') ?? 0),
                    'status'               => $this->request->getPost('status', true) === 'Inactive' ? 'Inactive' : 'Active',
                    'lang_id'              => 5,
                    'updated_at'           => date('Y-m-d H:i:s'),
                ]);

                $this->session->setFlashdata('success', 'Product updated successfully!');
                redirect(base_url() . $this->basePath);
            }

            $this->session->setFlashdata('error', $error);
            redirect(base_url() . $this->basePath . '/edit/' . $id);
        }

        echo view('admin/view_header', $data);
        echo view('admin/view_api_product_edit', $data);
        echo view('admin/view_footer');
    }

    public function delete($id = 0)
    {
        if (! is_numeric($id)) {
            redirect(base_url() . $this->basePath);
        }

        if (PROJECT_MODE == 0) {
            $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
            redirect(base_url() . $this->basePath);
        }

        $product = $this->Model_api_product->product_check((int) $id, $this->productType);

        if (! $product) {
            redirect(base_url() . $this->basePath);
        }

        $this->Model_api_product->delete((int) $id);
        $this->session->setFlashdata('success', 'Product deleted successfully!');
        redirect(base_url() . $this->basePath);
    }

    /**
     * @param array<string, mixed> $extra
     * @return array<string, mixed>
     */
    protected function moduleData(array $extra = []): array
    {
        return array_merge([
            'setting'       => $this->Model_common->get_setting_data(),
            'module_title'  => $this->moduleTitle,
            'base_path'     => $this->basePath,
            'product_type'  => $this->productType,
        ], $extra);
    }
}
