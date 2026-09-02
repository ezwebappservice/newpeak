<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Investor extends MY_Controller
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('investor');
        $this->Model_common = new \App\Models\Model_common();
        $this->Model_investor = new \App\Models\Model_investor();
    }

    public function index()
    {
        investor_set_nav_context('investor-relations');

        $groups = investor_category_tree();
        $parents = [];
        $totalDocuments = 0;

        foreach ($groups['parents'] as $parent) {
            $parentId = (int) $parent['id'];
            $children = $groups['children'][$parentId] ?? [];
            $parent['child_count'] = count($children);

            if ($children !== []) {
                $docCount = 0;

                foreach ($children as $child) {
                    $docCount += $this->Model_investor->document_count((int) $child['id']);
                }

                $parent['document_count'] = $docCount;
            } else {
                $parent['document_count'] = $this->Model_investor->document_count($parentId);
            }

            $totalDocuments += (int) $parent['document_count'];
            $parents[] = $parent;
        }

        $data = $this->layoutData([
            'page_title'         => 'Investor Relations',
            'meta_title'         => 'Investor Relations | Shivalik Rasayan Limited',
            'meta_description'   => 'Browse investor disclosures, financial reports, governance documents and shareholder information.',
            'investor_groups'    => $groups,
            'investor_parents'   => $parents,
            'category_count'     => count($parents),
            'total_documents'    => $totalDocuments,
            'hero_title'         => 'Investor Relations',
        ]);

        echo view('view_header', $data);
        echo view('view_investor', $data);
        echo view('view_footer', $data);
    }

    public function category($slug = '')
    {
        $category = $this->Model_investor->get_by_slug((string) $slug);

        if (! $category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $children = $this->Model_investor->active_children((int) $category['id']);

        if ($children === [] || ! empty($category['parent_id'])) {
            return redirect()->to(investor_documents_url($category));
        }

        investor_set_nav_context(investor_nav_slug_category($category));

        $subCategories = [];

        foreach ($children as $child) {
            $child['document_count'] = $this->Model_investor->document_count((int) $child['id']);
            $subCategories[] = $child;
        }

        $totalDocuments = array_sum(array_column($subCategories, 'document_count'));

        $data = $this->layoutData([
            'page_title'       => $category['category_name'],
            'meta_title'       => $category['category_name'] . ' | Investor Relations',
            'meta_description' => 'Browse ' . $category['category_name'] . ' investor documents and disclosures.',
            'investor_category'=> $category,
            'sub_categories'   => $subCategories,
            'section_count'    => count($subCategories),
            'total_documents'  => $totalDocuments,
            'hero_title'       => $category['category_name'],
        ]);

        echo view('view_header', $data);
        echo view('view_investor_category', $data);
        echo view('view_footer', $data);
    }

    public function documents($slug = '')
    {
        $category = $this->Model_investor->get_by_slug((string) $slug);

        if (! $category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $children = $this->Model_investor->active_children((int) $category['id']);

        if ($children !== []) {
            return redirect()->to(investor_category_url($category));
        }

        investor_set_nav_context(investor_nav_slug_document($category));

        $parentCategory = null;

        if (! empty($category['parent_id'])) {
            $parentCategory = $this->Model_investor->get_by_slug((string) ($category['parent_slug'] ?? ''));
        }

        $availableYears = $this->Model_investor->years_for_category((int) $category['id']);
        $defaultYear = $this->Model_investor->default_year_for_category((int) $category['id']);

        if ($availableYears === []) {
            $availableYears = investor_flat_year_list();
            $defaultYear = $availableYears[0] ?? '';
        } elseif ($defaultYear === '' || ! in_array($defaultYear, $availableYears, true)) {
            $defaultYear = $availableYears[0];
        }

        $data = $this->layoutData([
            'page_title'        => $category['category_name'],
            'meta_title'        => $category['category_name'] . ' | Investor Relations',
            'meta_description'  => 'Download and view ' . $category['category_name'] . ' investor documents.',
            'investor_category' => array_merge($category, [
                'document_count' => $this->Model_investor->document_count((int) $category['id']),
            ]),
            'parent_category'   => $parentCategory,
            'category_id'       => (int) $category['id'],
            'available_years'   => $availableYears,
            'default_year'      => $defaultYear,
            'documents_per_page'=> investor_config()->documentsPerPage,
            'document_types'    => investor_config()->documentTypes,
            'hero_title'        => $category['category_name'],
        ]);

        echo view('view_header', $data);
        echo view('view_investor_documents', $data);
        echo view('view_footer', $data);
    }

    public function documents_api()
    {
        helper('investor');
        $this->Model_investor = new \App\Models\Model_investor();

        $filters = [
            'category_id'   => $this->request->getGet('category_id'),
            'year'          => $this->request->getGet('year'),
            'document_type' => $this->request->getGet('document_type'),
            'keyword'       => trim((string) ($this->request->getGet('keyword') ?? '')),
        ];

        $page = max(1, (int) ($this->request->getGet('page') ?? 1));
        $perPage = max(1, min(50, (int) ($this->request->getGet('per_page') ?? investor_config()->documentsPerPage)));
        $offset = ($page - 1) * $perPage;

        $total = $this->Model_investor->count_documents($filters);
        $documents = $this->Model_investor->get_documents($filters, $perPage, $offset);

        $items = [];

        foreach ($documents as $doc) {
            $ext = strtolower(pathinfo($doc['original_file_name'] ?? '', PATHINFO_EXTENSION));
            $items[] = [
                'id'              => (int) $doc['id'],
                'file_title'      => $doc['file_title'],
                'title_type'      => $doc['title_type'] ?: '-',
                'document_type'   => $doc['document_type'] ?: '-',
                'upload_date'     => $doc['created_at'],
                'file_size'       => investor_format_file_size((int) $doc['file_size']),
                'download_url'    => base_url('investor/download/' . $doc['id']),
                'view_url'        => $ext === 'pdf' ? base_url('investor/view/' . $doc['id']) : null,
                'is_pdf'          => $ext === 'pdf',
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

    public function years()
    {
        $categoryId = (int) ($this->request->getGet('category_id') ?? 0);

        if ($categoryId <= 0) {
            return $this->response->setJSON(['success' => true, 'data' => investor_flat_year_list()]);
        }

        $years = $this->Model_investor->years_for_category($categoryId);

        if ($years === []) {
            $years = investor_flat_year_list();
        }

        return $this->response->setJSON(['success' => true, 'data' => $years]);
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

    public function document_types()
    {
        $categoryId = $this->request->getGet('category_id');
        $year = $this->request->getGet('year');

        $types = $this->Model_investor->document_types_for_filters(
            $categoryId ? (int) $categoryId : null,
            $year ?: null
        );

        return $this->response->setJSON(['success' => true, 'data' => $types]);
    }

    public function download($id = 0)
    {
        return $this->serveDocument((int) $id, false);
    }

    public function view($id = 0)
    {
        return $this->serveDocument((int) $id, true);
    }

    /**
     * @param array<string, mixed> $extra
     * @return array<string, mixed>
     */
    private function layoutData(array $extra = []): array
    {
        return array_merge([
            'setting'   => $this->Model_common->all_setting(),
            'page_home' => $this->Model_common->all_page_home(),
            'comment'   => $this->Model_common->all_comment(),
            'social'    => $this->Model_common->all_social(),
        ], $extra);
    }

    private function serveDocument(int $id, bool $inline)
    {
        if ($id <= 0) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $row = $this->Model_investor->get_document($id, true);

        if (! $row) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $path = investor_storage_path($row['file_name']);

        if (! is_file($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $downloadName = $row['original_file_name'] ?: $row['file_name'];
        $ext = strtolower(pathinfo($downloadName, PATHINFO_EXTENSION));

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
