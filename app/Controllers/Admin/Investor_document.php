<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Investor_document extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('investor');
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_investor_document = new \App\Models\Admin\Model_investor_document();
        $this->Model_investor_category = new \App\Models\Admin\Model_investor_category();
    }

    public function index()
    {
        $filters = [
            'keyword'       => trim((string) ($this->request->getGet('keyword') ?? '')),
            'category_id'   => $this->request->getGet('category_id'),
            'year'          => $this->request->getGet('year'),
            'document_type' => $this->request->getGet('document_type'),
            'status'        => $this->request->getGet('status'),
            'sort'          => $this->request->getGet('sort') ?? 'created_at',
            'order'         => $this->request->getGet('order') ?? 'desc',
        ];

        $data['setting'] = $this->Model_common->get_setting_data();
        $data['filters'] = $filters;
        $data['categories'] = $this->Model_investor_category->assignable_list();
        $data['year_options'] = investor_year_options();
        $data['document_types'] = investor_config()->documentTypes;
        $data['investor_documents'] = $this->Model_investor_document->show($filters);

        echo view('admin/view_header', $data);
        echo view('admin/view_investor_document', $data);
        echo view('admin/view_footer');
    }

    public function add()
    {
        $data['setting'] = $this->Model_common->get_setting_data();
        $data['categories'] = $this->Model_investor_category->assignable_list();
        $data['year_options'] = investor_year_options();
        $data['document_types'] = investor_config()->documentTypes;

        if (isset($_POST['form1'])) {
            if (PROJECT_MODE == 0) {
                $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
                redirect($_SERVER['HTTP_REFERER']);
            }

            $error = $this->saveDocument();

            if ($error === '') {
                $this->session->setFlashdata('success', 'Investor document uploaded successfully!');
                redirect(base_url() . 'admin/investor_document');
            }

            $this->session->setFlashdata('error', $error);
            redirect(base_url() . 'admin/investor_document/add');
        }

        echo view('admin/view_header', $data);
        echo view('admin/view_investor_document_add', $data);
        echo view('admin/view_footer');
    }

    public function edit($id = 0)
    {
        if (! is_numeric($id)) {
            redirect(base_url() . 'admin/investor_document');
        }

        $row = $this->Model_investor_document->investor_document_check($id);

        if (! $row) {
            redirect(base_url() . 'admin/investor_document');
        }

        $data['setting'] = $this->Model_common->get_setting_data();
        $data['categories'] = $this->Model_investor_category->assignable_list();
        $data['year_options'] = investor_year_options();
        $data['document_types'] = investor_config()->documentTypes;
        $data['investor_document'] = $this->Model_investor_document->getData($id);

        if (isset($_POST['form1'])) {
            if (PROJECT_MODE == 0) {
                $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
                redirect($_SERVER['HTTP_REFERER']);
            }

            $error = $this->saveDocument((int) $id, $row);

            if ($error === '') {
                $this->session->setFlashdata('success', 'Investor document updated successfully!');
                redirect(base_url() . 'admin/investor_document');
            }

            $this->session->setFlashdata('error', $error);
            redirect(base_url() . 'admin/investor_document/edit/' . $id);
        }

        echo view('admin/view_header', $data);
        echo view('admin/view_investor_document_edit', $data);
        echo view('admin/view_footer');
    }

    public function delete($id = 0)
    {
        if (! is_numeric($id)) {
            redirect(base_url() . 'admin/investor_document');
        }

        if (PROJECT_MODE == 0) {
            $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
            redirect(base_url() . 'admin/investor_document');
        }

        $row = $this->Model_investor_document->investor_document_check($id);

        if (! $row) {
            redirect(base_url() . 'admin/investor_document');
        }

        safe_unlink_investor($row['file_name']);
        $this->Model_investor_document->delete($id);
        $this->session->setFlashdata('success', 'Investor document deleted successfully!');
        redirect(base_url() . 'admin/investor_document');
    }

    public function toggle_status($id = 0)
    {
        if (! is_numeric($id)) {
            redirect(base_url() . 'admin/investor_document');
        }

        if (PROJECT_MODE == 0) {
            $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
            redirect(base_url() . 'admin/investor_document');
        }

        $row = $this->Model_investor_document->investor_document_check($id);

        if (! $row) {
            redirect(base_url() . 'admin/investor_document');
        }

        $newStatus = ($row['status'] ?? 'Active') === 'Active' ? 'Inactive' : 'Active';
        $this->Model_investor_document->update($id, [
            'status'     => $newStatus,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->session->setFlashdata('success', 'Document status updated to ' . $newStatus . '.');
        redirect(base_url() . 'admin/investor_document');
    }

    public function download($id = 0)
    {
        if (! is_numeric($id)) {
            redirect(base_url() . 'admin/investor_document');
        }

        $row = $this->Model_investor_document->investor_document_check($id);

        if (! $row) {
            redirect(base_url() . 'admin/investor_document');
        }

        $this->serveFile($row, false);
    }

    private function saveDocument(?int $id = null, ?array $existing = null): string
    {
        $valid = 1;
        $error = '';

        $categoryId = (int) $this->request->getPost('category_id', true);
        $year = trim((string) $this->request->getPost('year', true));
        $fileTitle = trim((string) $this->request->getPost('file_title', true));
        $titleType = trim((string) $this->request->getPost('title_type', true));
        $documentType = trim((string) $this->request->getPost('document_type', true));
        $status = $this->request->getPost('status', true) === 'Inactive' ? 'Inactive' : 'Active';

        $this->form_validation->set_rules('category_id', 'Investor Category', 'trim|required|integer');
        $this->form_validation->set_rules('year', 'Year', 'trim|required');
        $this->form_validation->set_rules('file_title', 'File Title', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('title_type', 'Title Type', 'trim|max_length[255]');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');

        if ($this->form_validation->run() == false) {
            $valid = 0;
            $error .= validation_errors();
        }

        if ($valid && ! $this->Model_investor_category->investor_category_check($categoryId)) {
            $valid = 0;
            $error .= 'Selected category is invalid.<br>';
        }

        if ($valid) {
            $assignableIds = array_map(static function ($row) {
                return (int) $row['id'];
            }, $this->Model_investor_category->assignable_list());

            if (! in_array($categoryId, $assignableIds, true)) {
                $valid = 0;
                $error .= 'Documents can only be assigned to sub-categories or categories without children.<br>';
            }
        }

        $allowedYears = investor_flat_year_list();

        if ($valid && ! in_array($year, $allowedYears, true)) {
            $valid = 0;
            $error .= 'Selected year is invalid.<br>';
        }

        $fileName = $existing['file_name'] ?? '';
        $originalName = $existing['original_file_name'] ?? '';
        $fileSize = (int) ($existing['file_size'] ?? 0);

        if (! empty($_FILES['upload_file']['name'])) {
            $uploadCheck = investor_validate_upload($_FILES['upload_file']);

            if (! $uploadCheck['valid']) {
                $valid = 0;
                $error .= $uploadCheck['error'] . '<br>';
            } else {
                $newFileName = investor_unique_filename($uploadCheck['ext']);

                if (! move_investor_upload($_FILES['upload_file']['tmp_name'], $newFileName)) {
                    $valid = 0;
                    $error .= 'Failed to upload file. Please try again.<br>';
                } else {
                    if ($id !== null && $fileName !== '') {
                        safe_unlink_investor($fileName);
                    }

                    $fileName = $newFileName;
                    $originalName = basename($_FILES['upload_file']['name']);
                    $fileSize = (int) $_FILES['upload_file']['size'];
                }
            }
        } elseif ($id === null) {
            $valid = 0;
            $error .= 'Please select a file to upload.<br>';
        }

        if ($valid != 1) {
            return $error;
        }

        $now = date('Y-m-d H:i:s');
        $payload = [
            'category_id'        => $categoryId,
            'year'               => $year,
            'file_title'         => $fileTitle,
            'title_type'         => $titleType !== '' ? $titleType : null,
            'document_type'      => $documentType !== '' ? $documentType : null,
            'file_name'          => $fileName,
            'original_file_name' => $originalName,
            'file_size'          => $fileSize,
            'status'             => $status,
            'updated_at'         => $now,
        ];

        if ($id === null) {
            $payload['created_at'] = $now;
            $this->Model_investor_document->add($payload);
        } else {
            $this->Model_investor_document->update($id, $payload);
        }

        return '';
    }

    private function serveFile(array $row, bool $inlinePdf): void
    {
        $path = investor_storage_path($row['file_name']);

        if (! is_file($path)) {
            $this->session->setFlashdata('error', 'File not found on server.');
            redirect(base_url() . 'admin/investor_document');

            return;
        }

        $mime = mime_content_type($path) ?: 'application/octet-stream';
        $downloadName = $row['original_file_name'] ?: $row['file_name'];
        $ext = strtolower(pathinfo($downloadName, PATHINFO_EXTENSION));

        if ($inlinePdf && $ext === 'pdf') {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . rawurlencode($downloadName) . '"');
        } else {
            header('Content-Type: ' . $mime);
            header('Content-Disposition: attachment; filename="' . rawurlencode($downloadName) . '"');
        }

        header('Content-Length: ' . filesize($path));
        header('Cache-Control: private, max-age=0, must-revalidate');
        readfile($path);
        exit;
    }
}
