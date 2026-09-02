<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Checkout extends MY_Controller
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Model_common();
        $this->Model_shop = new \App\Models\Model_shop();
        $this->Model_customer = new \App\Models\Model_customer();
        $this->Model_order = new \App\Models\Model_order();
        $this->Model_portfolio = new \App\Models\Model_portfolio();
    }

    protected function getCart(): array
    {
        return session()->get('shop_cart') ?? [];
    }

    protected function buildCartItems(): array
    {
        $cart = $this->getCart();
        $items = [];
        $total = 0;

        foreach ($cart as $productId => $qty) {
            $product = $this->Model_shop->get_product_by_id((int) $productId);
            if ($product) {
                $lineTotal = $product['price'] * $qty;
                $items[] = [
                    'product'    => $product,
                    'quantity'   => $qty,
                    'line_total' => $lineTotal,
                ];
                $total += $lineTotal;
            }
        }

        return ['items' => $items, 'total' => $total];
    }

    protected function commonData(): array
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

    protected function customerDefaults(): array
    {
        $defaults = [
            'first_name'    => '',
            'last_name'     => '',
            'email'         => '',
            'phone'         => '',
            'address_line1' => '',
            'address_line2' => '',
            'city'          => '',
            'state'         => '',
            'postal_code'   => '',
            'country'       => 'United States',
        ];

        $customerId = session()->get('shop_customer_id');
        if ($customerId) {
            $customer = $this->Model_customer->getById((int) $customerId);
            if ($customer) {
                return array_merge($defaults, $customer);
            }
        }

        return $defaults;
    }

    public function index()
    {
        $cartData = $this->buildCartItems();
        if ($cartData['items'] === []) {
            $this->session->setFlashdata('error', 'Your cart is empty.');
            return redirect()->to(base_url('cart'));
        }

        $data = $this->commonData();
        $data['cart_items'] = $cartData['items'];
        $data['cart_total'] = $cartData['total'];
        $data['customer'] = $this->customerDefaults();
        $data['is_logged_in'] = (bool) session()->get('shop_customer_id');
        $data['old'] = $data['customer'];

        if ($this->request->getMethod() === 'POST') {
            return $this->placeOrder();
        }

        echo view('view_header', $data);
        echo view('view_checkout', $data);
        echo view('view_footer', $data);
    }

    protected function placeOrder()
    {
        $cartData = $this->buildCartItems();
        if ($cartData['items'] === []) {
            $this->session->setFlashdata('error', 'Your cart is empty.');
            return redirect()->to(base_url('cart'));
        }

        $fields = [
            'first_name'    => trim((string) $this->request->getPost('first_name')),
            'last_name'     => trim((string) $this->request->getPost('last_name')),
            'email'         => trim((string) $this->request->getPost('email')),
            'phone'         => trim((string) $this->request->getPost('phone')),
            'address_line1' => trim((string) $this->request->getPost('address_line1')),
            'address_line2' => trim((string) $this->request->getPost('address_line2')),
            'city'          => trim((string) $this->request->getPost('city')),
            'state'         => trim((string) $this->request->getPost('state')),
            'postal_code'   => trim((string) $this->request->getPost('postal_code')),
            'country'       => trim((string) $this->request->getPost('country')),
        ];

        $paymentMethod = $this->request->getPost('payment_method') ?? 'cod';
        $orderNotes = trim((string) $this->request->getPost('order_notes'));
        $saveAddress = $this->request->getPost('save_address') === '1';

        $errors = [];
        if ($fields['first_name'] === '') {
            $errors[] = 'First name is required.';
        }
        if ($fields['last_name'] === '') {
            $errors[] = 'Last name is required.';
        }
        if ($fields['email'] === '' || ! filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'A valid email is required.';
        }
        if ($fields['phone'] === '') {
            $errors[] = 'Phone number is required.';
        }
        if ($fields['address_line1'] === '') {
            $errors[] = 'Street address is required.';
        }
        if ($fields['city'] === '') {
            $errors[] = 'City is required.';
        }
        if ($fields['state'] === '') {
            $errors[] = 'State is required.';
        }
        if ($fields['postal_code'] === '') {
            $errors[] = 'Postal code is required.';
        }

        foreach ($cartData['items'] as $item) {
            if ($item['quantity'] > $item['product']['stock_quantity']) {
                $errors[] = esc($item['product']['product_name']) . ' does not have enough stock.';
            }
        }

        if ($errors !== []) {
            $data = $this->commonData();
            $data['cart_items'] = $cartData['items'];
            $data['cart_total'] = $cartData['total'];
            $data['old'] = $fields;
            $data['is_logged_in'] = (bool) session()->get('shop_customer_id');
            $data['customer'] = $this->customerDefaults();
            $this->session->setFlashdata('error', implode('<br>', $errors));

            echo view('view_header', $data);
            echo view('view_checkout', $data);
            echo view('view_footer', $data);

            return;
        }

        $customerId = session()->get('shop_customer_id') ? (int) session()->get('shop_customer_id') : null;

        if ($saveAddress && $customerId) {
            $this->Model_customer->updateProfile($customerId, $fields);
        }

        $orderNumber = $this->Model_order->generateOrderNumber();
        $orderItems = [];

        foreach ($cartData['items'] as $item) {
            $p = $item['product'];
            $orderItems[] = [
                'product_id'   => $p['product_id'],
                'product_name' => $p['product_name'],
                'price'        => $p['price'],
                'quantity'     => $item['quantity'],
                'line_total'   => $item['line_total'],
            ];
        }

        $orderId = $this->Model_order->createOrder([
            'order_number'   => $orderNumber,
            'customer_id'    => $customerId,
            'guest_email'    => $customerId ? null : $fields['email'],
            'first_name'     => $fields['first_name'],
            'last_name'      => $fields['last_name'],
            'phone'          => $fields['phone'],
            'email'          => $fields['email'],
            'address_line1'  => $fields['address_line1'],
            'address_line2'  => $fields['address_line2'],
            'city'           => $fields['city'],
            'state'          => $fields['state'],
            'postal_code'    => $fields['postal_code'],
            'country'        => $fields['country'] ?: 'United States',
            'subtotal'       => $cartData['total'],
            'total'          => $cartData['total'],
            'payment_method' => $paymentMethod,
            'order_status'   => 'pending',
            'order_notes'    => $orderNotes,
        ], $orderItems);

        foreach ($cartData['items'] as $item) {
            $this->Model_order->decrementStock((int) $item['product']['product_id'], (int) $item['quantity']);
        }

        session()->remove('shop_cart');
        session()->set('last_order_number', $orderNumber);
        session()->set('last_order_id', $orderId);

        return redirect()->to(base_url('checkout/success'));
    }

    public function success()
    {
        $orderNumber = session()->get('last_order_number');
        if (! $orderNumber) {
            return redirect()->to(base_url('shop'));
        }

        $order = $this->Model_order->getByNumber($orderNumber);
        $data = $this->commonData();
        $data['order'] = $order;
        $data['order_items'] = $order ? $this->Model_order->getItems((int) $order['order_id']) : [];

        echo view('view_header', $data);
        echo view('view_checkout_success', $data);
        echo view('view_footer', $data);
    }
}
