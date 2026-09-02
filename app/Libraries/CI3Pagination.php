<?php

namespace App\Libraries;

/**
 * CodeIgniter 3 style pagination library.
 */
class CI3Pagination
{
    /** @var array<string, mixed> */
    protected array $config = [];

    public function initialize(array $config = []): self
    {
        $defaults = [
            'base_url'           => '',
            'total_rows'         => 0,
            'per_page'           => 10,
            'uri_segment'        => 3,
            'use_page_numbers'   => false,
            'first_url'          => '',
            'full_tag_open'      => '',
            'full_tag_close'     => '',
            'num_tag_open'       => '',
            'num_tag_close'      => '',
            'cur_tag_open'       => '',
            'cur_tag_close'      => '',
            'next_tag_open'      => '',
            'next_tag_close'     => '',
            'prev_tag_open'      => '',
            'prev_tag_close'     => '',
            'first_tag_open'     => '',
            'first_tag_close'    => '',
            'last_tag_open'      => '',
            'last_tag_close'     => '',
            'next_link'          => '&raquo;',
            'prev_link'          => '&laquo;',
            'first_link'         => 'First',
            'last_link'          => 'Last',
        ];

        $this->config = array_merge($defaults, $config);

        return $this;
    }

    public function create_links(): string
    {
        $totalRows = (int) ($this->config['total_rows'] ?? 0);
        $perPage   = max(1, (int) ($this->config['per_page'] ?? 10));

        if ($totalRows <= $perPage) {
            return '';
        }

        $numPages = (int) ceil($totalRows / $perPage);
        $segment  = (int) ($this->config['uri_segment'] ?? 3);
        $uri      = service('uri');
        $current  = 1;

        if ($segment > 0 && $segment <= $uri->getTotalSegments()) {
            $current = (int) ($uri->getSegment($segment) ?: 1);
        }

        if ($current < 1) {
            $current = 1;
        }
        if ($current > $numPages) {
            $current = $numPages;
        }

        $baseUrl = rtrim((string) $this->config['base_url'], '/');
        $output  = $this->config['full_tag_open'];

        if ($current > 1) {
            $output .= $this->config['first_tag_open']
                . $this->anchor($this->pageUrl(1), (string) $this->config['first_link'])
                . $this->config['first_tag_close'];
            $output .= $this->config['prev_tag_open']
                . $this->anchor($this->pageUrl($current - 1), (string) $this->config['prev_link'])
                . $this->config['prev_tag_close'];
        }

        for ($i = 1; $i <= $numPages; $i++) {
            if ($i === $current) {
                $output .= $this->config['cur_tag_open'] . $i . $this->config['cur_tag_close'];
            } else {
                $output .= $this->config['num_tag_open']
                    . $this->anchor($this->pageUrl($i), (string) $i)
                    . $this->config['num_tag_close'];
            }
        }

        if ($current < $numPages) {
            $output .= $this->config['next_tag_open']
                . $this->anchor($this->pageUrl($current + 1), (string) $this->config['next_link'])
                . $this->config['next_tag_close'];
            $output .= $this->config['last_tag_open']
                . $this->anchor($this->pageUrl($numPages), (string) $this->config['last_link'])
                . $this->config['last_tag_close'];
        }

        return $output . $this->config['full_tag_close'];
    }

    protected function pageUrl(int $page): string
    {
        if ($page === 1 && ! empty($this->config['first_url'])) {
            return (string) $this->config['first_url'];
        }

        $base = rtrim((string) $this->config['base_url'], '/');

        return $base . '/' . $page;
    }

    protected function anchor(string $url, string $text): string
    {
        return '<a href="' . esc($url, 'attr') . '">' . $text . '</a>';
    }
}
