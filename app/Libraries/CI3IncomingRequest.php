<?php

namespace App\Libraries;

use CodeIgniter\HTTP\IncomingRequest;

/**
 * CI3 compatibility: getPost('field', true) used true for XSS cleaning;
 * CI4 expects an int filter constant as the second argument.
 */
class CI3IncomingRequest extends IncomingRequest
{
    private function normalizeFilter($filter): ?int
    {
        if ($filter === true) {
            return FILTER_SANITIZE_FULL_SPECIAL_CHARS;
        }

        if ($filter === false) {
            return null;
        }

        return is_int($filter) ? $filter : null;
    }

    public function getVar($index = null, $filter = null, $flags = null)
    {
        return parent::getVar($index, $this->normalizeFilter($filter), $flags);
    }

    public function getGet($index = null, $filter = null, $flags = null)
    {
        return parent::getGet($index, $this->normalizeFilter($filter), $flags);
    }

    public function getPost($index = null, $filter = null, $flags = null)
    {
        return parent::getPost($index, $this->normalizeFilter($filter), $flags);
    }

    public function getPostGet($index = null, $filter = null, $flags = null)
    {
        return parent::getPostGet($index, $this->normalizeFilter($filter), $flags);
    }

    public function getGetPost($index = null, $filter = null, $flags = null)
    {
        return parent::getGetPost($index, $this->normalizeFilter($filter), $flags);
    }

    public function getCookie($index = null, $filter = null, $flags = null)
    {
        return parent::getCookie($index, $this->normalizeFilter($filter), $flags);
    }
}
