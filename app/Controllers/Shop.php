<?php
namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Shop extends MY_Controller
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Model_common();
        $this->Model_shop = new \App\Models\Model_shop();
        $this->Model_portfolio = new \App\Models\Model_portfolio();
    }

    protected function commonData()
    {
        return [
            'setting'          => $this->Model_common->all_setting(),
            'page_home'        => $this->Model_common->all_page_home(),
            'comment'          => $this->Model_common->all_comment(),
            'social'           => $this->Model_common->all_social(),
            'all_news'         => $this->Model_common->all_news(),
            'portfolio_footer' => $this->Model_portfolio->get_portfolio_data(),
        ];
    }

    public function index()
    {
        $data = $this->commonData();
        $data['parent_categories'] = $this->Model_shop->parent_categories();
        $data['featured_products'] = $this->Model_shop->all_products();

        echo view('view_header', $data);
        echo view('view_shop', $data);
        echo view('view_footer', $data);
    }

    public function category($slug = '')
    {
        $category = $this->Model_shop->parent_category_by_slug($slug);
        if (!$category) {
            return redirect()->to(base_url('shop'));
        }

        $data = $this->commonData();
        $data['category'] = $category;
        $data['sub_categories'] = $this->Model_shop->sub_categories_by_parent($category['parent_category_id']);
        $data['products'] = $this->Model_shop->products_by_parent_category($category['parent_category_id']);

        echo view('view_header', $data);
        echo view('view_shop_category', $data);
        echo view('view_footer', $data);
    }

    public function subcategory($slug = '')
    {
        $category = $this->Model_shop->sub_category_by_slug($slug);
        if (!$category) {
            return redirect()->to(base_url('shop'));
        }

        $data = $this->commonData();
        $data['category'] = $category;
        $data['products'] = $this->Model_shop->products_by_sub_category($category['sub_category_id']);

        echo view('view_header', $data);
        echo view('view_shop_subcategory', $data);
        echo view('view_footer', $data);
    }

    public function product($slug = '')
    {
        $product = $this->Model_shop->product_by_slug($slug);
        if (!$product) {
            return redirect()->to(base_url('shop'));
        }

        $data = $this->commonData();
        $data['product'] = $product;
        $data['product_images'] = $this->Model_shop->product_images($product['product_id']);
        $data['category_mapping'] = $this->Model_shop->product_category_mapping($product['product_id']);

        $parent_id = $data['category_mapping']['parent_category_id'] ?? 0;
        $data['related_products'] = $parent_id
            ? $this->Model_shop->related_products($product['product_id'], $parent_id, 4)
            : [];

        echo view('view_header', $data);
        echo view('view_product_detail', $data);
        echo view('view_footer', $data);
    }

    public function search()
    {
        $keyword = trim($this->request->getPost('keyword') ?? $this->request->getGet('q') ?? '');
        $data = $this->commonData();
        $data['keyword'] = $keyword;
        $data['products'] = $keyword ? $this->Model_shop->search_products($keyword) : [];

        echo view('view_header', $data);
        echo view('view_shop_search', $data);
        echo view('view_footer', $data);
    }
}
