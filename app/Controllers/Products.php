<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Products extends MY_Controller
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Model_common();
        $this->Model_portfolio = new \App\Models\Model_portfolio();
        $this->Model_page = new \App\Models\Model_page();
        $this->Model_api_product = new \App\Models\Model_api_product();
    }

    public function oncology()
    {
        $this->renderProductPage('oncology-products', 'oncology');
    }

    public function nonOncology()
    {
        $this->renderProductPage('non-oncology-products', 'non_oncology');
    }

    private function renderProductPage(string $slug, string $productType): void
    {
        $page = $this->Model_page->dynamic_page_by_slug($slug);

        if (! $page) {
            throw PageNotFoundException::forPageNotFound();
        }

        $products = $this->Model_api_product->active_list($productType);
        $GLOBALS['theme_current_page_slug'] = $slug;

        $data = [
            'setting'            => $this->Model_common->all_setting(),
            'comment'            => $this->Model_common->all_comment(),
            'social'             => $this->Model_common->all_social(),
            'all_news'           => $this->Model_common->all_news(),
            'portfolio_footer'   => $this->Model_portfolio->get_portfolio_data(),
            'page_dynamic_detail'=> $page,
            'current_page_slug'  => $slug,
            'api_products'       => $products,
            'product_type'       => $productType,
        ];

        echo view('view_header', $data);
        echo view('view_api_product_list', $data);
        echo view('view_footer', $data);
    }
}
