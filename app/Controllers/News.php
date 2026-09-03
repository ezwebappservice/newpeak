<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class News extends MY_Controller
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('news');
        $this->Model_common = new \App\Models\Model_common();
        $this->Model_news = new \App\Models\Model_news();
        $this->Model_portfolio = new \App\Models\Model_portfolio();
    }

    /**
     * Live site URL: /latest-news/
     */
    public function latestNews()
    {
        $page = max(1, (int) ($this->request->getGet('page') ?? 1));
        $perPage = 9;
        $offset = ($page - 1) * $perPage;
        $total = $this->Model_news->get_total_news();
        $totalPages = max(1, (int) ceil($total / $perPage));

        if ($page > $totalPages && $total > 0) {
            throw PageNotFoundException::forPageNotFound();
        }

        $data = $this->baseData();
        $data['news_items'] = $this->Model_news->fetch_news($perPage, $offset);
        $data['pagination'] = [
            'page'        => $page,
            'per_page'    => $perPage,
            'total'       => $total,
            'total_pages' => $totalPages,
        ];
        $data['page_title'] = 'News';
        $data['page_subtitle'] = 'Latest Updates';
        $data['meta_title'] = 'News | Peak Potential';
        $data['meta_description'] = 'Latest news and updates from Peak Potential
        $GLOBALS['theme_current_page_slug'] = 'latest-news';

        echo view('view_header', $data);
        echo view('view_latest_news', $data);
        echo view('view_footer', $data);
    }

    /**
     * Live site detail URL: /latest-news/{slug}/
     */
    public function detail(string $slug = '')
    {
        $slug = trim($slug, '/');

        if ($slug === '') {
            return redirect()->to(news_url());
        }

        $detail = $this->Model_news->news_detail_by_slug($slug);

        if (! $detail) {
            throw PageNotFoundException::forPageNotFound();
        }

        $data = $this->baseData();
        $data['news_detail'] = $detail;
        $data['recent_news'] = $this->Model_news->recent_news(4, (int) $detail['news_id']);
        $data['meta_title'] = $detail['meta_title'] ?: ($detail['news_title'] . ' | Peak Potential
        $data['meta_description'] = $detail['meta_description'] ?: ($detail['news_content_short'] ?? '');
        $data['meta_keywords'] = $detail['meta_keyword'] ?? '';
        $data['og_tags'] = '<meta property="og:title" content="' . esc($detail['news_title']) . '">'
            . '<meta property="og:type" content="article">'
            . '<meta property="og:url" content="' . esc(news_url($detail['news_slug']), 'attr') . '">'
            . '<meta property="og:description" content="' . esc($detail['news_content_short'] ?? '') . '">'
            . '<meta property="og:image" content="' . esc(base_url('public/uploads/' . ($detail['photo'] ?? '')), 'attr') . '">';
        $GLOBALS['theme_current_page_slug'] = 'latest-news';

        echo view('view_header', $data);
        echo view('view_latest_news_detail', $data);
        echo view('view_footer', $data);
    }

    /** @deprecated Use latest-news */
    public function index()
    {
        return redirect()->to(news_url());
    }

    /** @deprecated Redirect old ID URLs to slug */
    public function view($id = 0)
    {
        if (! is_numeric($id)) {
            return redirect()->to(news_url());
        }

        $row = $this->Model_news->news_detail((int) $id);

        if (! $row) {
            throw PageNotFoundException::forPageNotFound();
        }

        if (! empty($row['news_slug'])) {
            return redirect()->to(news_url($row['news_slug']), 301);
        }

        throw PageNotFoundException::forPageNotFound();
    }

    /**
     * @return array<string, mixed>
     */
    private function baseData(): array
    {
        return [
            'setting'          => $this->Model_common->all_setting(),
            'page_home'        => $this->Model_common->all_page_home(),
            'page_news'        => $this->Model_common->all_page_news(),
            'comment'          => $this->Model_common->all_comment(),
            'social'           => $this->Model_common->all_social(),
            'all_news'         => $this->Model_common->all_news(),
            'portfolio_footer' => $this->Model_portfolio->get_portfolio_data(),
        ];
    }
}
