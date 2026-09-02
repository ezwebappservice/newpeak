<?php
namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Cart extends MY_Controller
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Model_common();
        $this->Model_shop = new \App\Models\Model_shop();
        $this->Model_portfolio = new \App\Models\Model_portfolio();
    }

    protected function getCart(): array
    {
        return session()->get('shop_cart') ?? [];
    }

    protected function saveCart(array $cart): void
    {
        session()->set('shop_cart', $cart);
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
        $cart = $this->getCart();
        $data['cart_items'] = [];
        $data['cart_total'] = 0;

        foreach ($cart as $product_id => $qty) {
            $product = $this->Model_shop->get_product_by_id($product_id);
            if ($product) {
                $line_total = $product['price'] * $qty;
                $data['cart_items'][] = [
                    'product'    => $product,
                    'quantity'   => $qty,
                    'line_total' => $line_total,
                ];
                $data['cart_total'] += $line_total;
            }
        }

        echo view('view_header', $data);
        echo view('view_cart', $data);
        echo view('view_footer', $data);
    }

    public function add()
    {
        $product_id = (int) ($this->request->getPost('product_id') ?? 0);
        $quantity = max(1, (int) ($this->request->getPost('quantity') ?? 1));

        $product = $this->Model_shop->get_product_by_id($product_id);
        if (!$product) {
            $this->session->setFlashdata('error', 'Product not found.');
            return redirect()->to(base_url('shop'));
        }

        if ($product['stock_quantity'] < 1) {
            $this->session->setFlashdata('error', 'Product is out of stock.');
            return redirect()->to(base_url('shop/product/' . $product['product_slug']));
        }

        $cart = $this->getCart();
        $new_qty = ($cart[$product_id] ?? 0) + $quantity;

        if ($new_qty > $product['stock_quantity']) {
            $this->session->setFlashdata('error', 'Not enough stock available.');
            return redirect()->to(base_url('shop/product/' . $product['product_slug']));
        }

        $cart[$product_id] = $new_qty;
        $this->saveCart($cart);
        $this->session->setFlashdata('success', 'Product added to cart.');

        $redirect = $this->request->getPost('redirect') ?? base_url('cart');
        return redirect()->to($redirect);
    }

    public function update()
    {
        $quantities = $this->request->getPost('quantity') ?? [];
        $cart = $this->getCart();

        foreach ($quantities as $product_id => $qty) {
            $product_id = (int) $product_id;
            $qty = max(0, (int) $qty);
            if ($qty === 0) {
                unset($cart[$product_id]);
                continue;
            }
            $product = $this->Model_shop->get_product_by_id($product_id);
            if ($product && $qty <= $product['stock_quantity']) {
                $cart[$product_id] = $qty;
            }
        }

        $this->saveCart($cart);
        $this->session->setFlashdata('success', 'Cart updated.');
        return redirect()->to(base_url('cart'));
    }

    public function remove($product_id = 0)
    {
        $cart = $this->getCart();
        unset($cart[(int) $product_id]);
        $this->saveCart($cart);
        $this->session->setFlashdata('success', 'Item removed from cart.');
        return redirect()->to(base_url('cart'));
    }

    public function clear()
    {
        $this->saveCart([]);
        $this->session->setFlashdata('success', 'Cart cleared.');
        return redirect()->to(base_url('cart'));
    }
}
