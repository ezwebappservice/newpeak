<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Shop_order extends BaseController
{
    protected array $allowedStatuses = ['pending', 'processing', 'completed', 'cancelled'];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_shop_order = new \App\Models\Admin\Model_shop_order();
    }

    public function index()
    {
        $data['setting'] = $this->Model_common->get_setting_data();
        $data['orders'] = $this->Model_shop_order->show();
        $data['status_counts'] = $this->Model_shop_order->countByStatus();

        echo view('admin/view_header', $data);
        echo view('admin/view_shop_order', $data);
        echo view('admin/view_footer');
    }

    public function view($orderId = 0)
    {
        $order = $this->Model_shop_order->getById((int) $orderId);
        if (! $order) {
            redirect(base_url('admin/shop_order'));
            exit;
        }

        $data['setting'] = $this->Model_common->get_setting_data();
        $data['order'] = $order;
        $data['order_items'] = $this->Model_shop_order->getItems((int) $orderId);
        $data['allowed_statuses'] = $this->allowedStatuses;

        echo view('admin/view_header', $data);
        echo view('admin/view_shop_order_detail', $data);
        echo view('admin/view_footer');
    }

    public function update_status($orderId = 0)
    {
        $order = $this->Model_shop_order->getById((int) $orderId);
        if (! $order) {
            redirect(base_url('admin/shop_order'));
            exit;
        }

        if (PROJECT_MODE == 0) {
            $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
            redirect(base_url('admin/shop_order/view/' . $orderId));
        }

        $status = $this->request->getPost('order_status') ?? '';
        if (! in_array($status, $this->allowedStatuses, true)) {
            $this->session->setFlashdata('error', 'Invalid order status.');
            redirect(base_url('admin/shop_order/view/' . $orderId));
        }

        $this->Model_shop_order->updateStatus((int) $orderId, $status);
        $this->session->setFlashdata('success', 'Order status updated successfully.');
        redirect(base_url('admin/shop_order/view/' . $orderId));
    }

    public function delete($orderId = 0)
    {
        $order = $this->Model_shop_order->getById((int) $orderId);
        if (! $order) {
            redirect(base_url('admin/shop_order'));
            exit;
        }

        if (PROJECT_MODE == 0) {
            $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
            redirect(base_url('admin/shop_order'));
        }

        $this->Model_shop_order->delete((int) $orderId);

        $this->session->setFlashdata('success', 'Order deleted successfully.');
        redirect(base_url('admin/shop_order'));
    }
}
