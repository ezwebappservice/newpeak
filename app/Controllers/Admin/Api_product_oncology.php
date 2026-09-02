<?php

namespace App\Controllers\Admin;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Api_product_oncology extends Api_product_admin
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->productType = 'oncology';
        $this->moduleTitle = 'Oncology API Products';
        $this->basePath = 'admin/api_product_oncology';
    }
}
