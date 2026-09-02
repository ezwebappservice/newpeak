<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Investor extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('investor');
        $this->Model_investor = new \App\Models\Model_investor();
    }

    public function categories()
    {
        $tree = investor_category_tree();
        $categories = [];

        foreach ($tree['parents'] as $parent) {
            $categories[] = $parent;

            foreach ($tree['children'][(int) $parent['id']] ?? [] as $child) {
                $categories[] = $child;
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'data'    => $categories,
        ]);
    }

    public function subcategories()
    {
        $parentId = (int) ($this->request->getGet('parent_id') ?? 0);

        if ($parentId <= 0) {
            return $this->response->setJSON(['success' => true, 'data' => []]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data'    => $this->Model_investor->active_children($parentId),
        ]);
    }

    public function years()
    {
        $categoryId = (int) ($this->request->getGet('category_id') ?? 0);

        if ($categoryId <= 0) {
            return $this->response->setJSON([
                'success' => true,
                'data'    => investor_flat_year_list(),
            ]);
        }

        $years = $this->Model_investor->years_for_category($categoryId);

        if ($years === []) {
            $years = investor_flat_year_list();
        }

        return $this->response->setJSON([
            'success' => true,
            'data'    => $years,
        ]);
    }

    public function document_types()
    {
        $categoryId = $this->request->getGet('category_id');
        $year = $this->request->getGet('year');

        $types = $this->Model_investor->document_types_for_filters(
            $categoryId ? (int) $categoryId : null,
            $year ?: null
        );

        if ($types === []) {
            $types = investor_config()->documentTypes;
        }

        return $this->response->setJSON([
            'success' => true,
            'data'    => $types,
        ]);
    }

    public function documents()
    {
        $filters = [
            'category_id'   => $this->request->getGet('category_id'),
            'year'          => $this->request->getGet('year'),
            'document_type' => $this->request->getGet('document_type'),
            'keyword'       => trim((string) ($this->request->getGet('keyword') ?? '')),
        ];

        $page = max(1, (int) ($this->request->getGet('page') ?? 1));
        $perPage = max(1, min(100, (int) ($this->request->getGet('per_page') ?? 10)));
        $offset = ($page - 1) * $perPage;

        $total = $this->Model_investor->count_documents($filters);
        $documents = $this->Model_investor->get_documents($filters, $perPage, $offset);

        $items = [];

        foreach ($documents as $doc) {
            $ext = strtolower(pathinfo($doc['original_file_name'] ?? '', PATHINFO_EXTENSION));
            $items[] = [
                'id'                => (int) $doc['id'],
                'category_id'       => (int) $doc['category_id'],
                'category_name'     => $doc['category_name'],
                'year'              => $doc['year'],
                'file_title'        => $doc['file_title'],
                'title_type'        => $doc['title_type'],
                'document_type'     => $doc['document_type'],
                'original_file_name'=> $doc['original_file_name'],
                'file_size'         => (int) $doc['file_size'],
                'file_size_label'   => investor_format_file_size((int) $doc['file_size']),
                'upload_date'       => $doc['created_at'],
                'download_url'      => base_url('api/investor/download/' . $doc['id']),
                'view_url'          => $ext === 'pdf' ? base_url('api/investor/view/' . $doc['id']) : null,
            ];
        }

        return $this->response->setJSON([
            'success'    => true,
            'data'       => $items,
            'pagination' => [
                'page'        => $page,
                'per_page'    => $perPage,
                'total'       => $total,
                'total_pages' => (int) ceil($total / $perPage),
            ],
        ]);
    }

    public function download($id = 0)
    {
        return $this->serveDocument((int) $id, false);
    }

    public function view($id = 0)
    {
        return $this->serveDocument((int) $id, true);
    }

    private function serveDocument(int $id, bool $inline)
    {
        if ($id <= 0) {
            return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Document not found.']);
        }

        $row = $this->Model_investor->get_document($id, true);

        if (! $row) {
            return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Document not found.']);
        }

        $path = investor_storage_path($row['file_name']);

        if (! is_file($path)) {
            return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'File not found on server.']);
        }

        $downloadName = $row['original_file_name'] ?: $row['file_name'];
        $ext = strtolower(pathinfo($downloadName, PATHINFO_EXTENSION));
        $mime = mime_content_type($path) ?: 'application/octet-stream';

        if ($inline && $ext === 'pdf') {
            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setHeader('Content-Disposition', 'inline; filename="' . $downloadName . '"')
                ->setHeader('Content-Length', (string) filesize($path))
                ->setBody(file_get_contents($path));
        }

        return $this->response->download($path, null)->setFileName($downloadName);
    }
}
