<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuth implements FilterInterface
{
    /** @var list<string> */
    private array $publicSegments = [
        '',
        'login',
        'forget-password',
        'forget_password',
        'reset-password',
        'reset_password',
    ];

    public function before(RequestInterface $request, $arguments = null)
    {
        $uri = service('uri');

        if (strtolower($uri->getSegment(1) ?? '') !== 'admin') {
            return;
        }

        $segment2 = strtolower($uri->getSegment(2) ?? '');

        if (in_array($segment2, $this->publicSegments, true)) {
            return;
        }

        $session = session();

        if (! $session->get('logged_in') || ! $session->get('id')) {
            return redirect()->to(base_url('admin'))
                ->with('error', 'Please sign in to continue.');
        }

        $status = $session->get('status');

        if ($status === 'Inactive' || $status === 0 || $status === '0') {
            $session->destroy();

            return redirect()->to(base_url('admin'))
                ->with('error', 'Your account is inactive.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
