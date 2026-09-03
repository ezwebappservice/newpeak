<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class MY_Controller extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        helper(['form', 'url', 'theme', 'contact', 'news', 'nav_menu']);

        $_SESSION['sess_lang_id'] = $_SESSION['sess_lang_id'] ?? 1;
        $_SESSION['sess_layout_direction'] = $_SESSION['sess_layout_direction'] ?? 'Left';

        try {
            $this->Model_lang = new \App\Models\Model_lang();
            $lang = $this->Model_lang->get_default_language_id();
            if ($lang) {
                $_SESSION['sess_lang_id'] = $lang['lang_id'] ?? $_SESSION['sess_lang_id'];
                $_SESSION['sess_layout_direction'] = $lang['layout_direction'] ?? $_SESSION['sess_layout_direction'];
            }

            $detail_arr = $this->Model_lang->get_detail_by_language_id($_SESSION['sess_lang_id']) ?: [];
            foreach ($detail_arr as $row) {
                if (! defined($row['lang_string'])) {
                    define($row['lang_string'], $row['lang_string_value']);
                }
            }
        } catch (\Throwable $e) {
            log_message('debug', 'Language tables unavailable: ' . $e->getMessage());
        }
    }

    protected function frontend_data(array $extra = []): array
    {
        $page = $extra['current_page'] ?? 'home';
        $GLOBALS['peak_current_page'] = $page;

        $setting = [];
        $social = [];
        $comment = [];
        $page_home = [];
        $page_home_lang_independent = [];

        try {
            if (! isset($this->Model_common)) {
                $this->Model_common = new \App\Models\Model_common();
            }
            $setting = $this->Model_common->all_setting() ?: [];
            $social = $this->Model_common->all_social() ?: [];
            $comment = $this->Model_common->all_comment() ?: [];
            $page_home = $this->Model_common->all_page_home() ?: [];
            $page_home_lang_independent = $this->Model_common->all_page_home_lang_independent() ?: [];
            if (! isset($extra['page_contact'])) {
                $extra['page_contact'] = $this->Model_common->all_page_contact() ?: [];
            }
        } catch (\Throwable $e) {
            log_message('debug', 'CMS settings unavailable: ' . $e->getMessage());
        }

        return array_merge([
            'setting'                     => $setting,
            'social'                      => $social,
            'comment'                     => $comment,
            'page_home'                   => $page_home,
            'page_home_lang_independent'  => $page_home_lang_independent,
            'page_contact'                => $extra['page_contact'] ?? [],
            'current_page'                => $page,
        ], $extra);
    }

    protected function safe_cms_page(string $method): array
    {
        try {
            if (! isset($this->Model_common)) {
                $this->Model_common = new \App\Models\Model_common();
            }
            $row = $this->Model_common->{$method}();

            return is_array($row) ? $row : [];
        } catch (\Throwable $e) {
            log_message('debug', 'CMS page unavailable: ' . $e->getMessage());

            return [];
        }
    }

    protected function render_frontend(string $view, array $extra = []): void
    {
        $data = $this->frontend_data($extra);
        echo view('view_header', $data);
        echo view($view, $data);
        echo view('view_footer', $data);
    }
}
