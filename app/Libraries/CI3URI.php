<?php

namespace App\Libraries;

/**
 * CodeIgniter 3 style URI helper.
 */
class CI3URI
{
    public function segment(int $segment, string $default = '')
    {
        $uri = service('uri');

        if ($segment < 1 || $segment > $uri->getTotalSegments()) {
            return $default;
        }

        return $uri->getSegment($segment, $default);
    }
}
