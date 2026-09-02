<?php

/**
 * CodeIgniter 3 compatibility helpers loaded before system Common.php.
 */

if (! function_exists('validation_errors')) {
    /**
     * CI3-style validation error string output.
     */
    function validation_errors(string $prefix = '', string $suffix = ''): string
    {
        $errors = session()->getFlashdata('_ci_validation_errors');

        if ($errors === null) {
            $errors = session('_ci_validation_errors');
        }

        if ($errors === null) {
            $errors = service('validation')->getErrors();
        }

        if ($errors === null || $errors === [] || $errors === '') {
            return '';
        }

        if (is_string($errors)) {
            return $errors;
        }

        $output = '';

        foreach ($errors as $error) {
            if ($error === '' || $error === null) {
                continue;
            }

            $output .= $prefix . $error . $suffix;
        }

        return $output;
    }
}

if (! function_exists('redirect')) {
    /**
     * CI3-compatible redirect that exits, while supporting redirect()->to().
     */
    function redirect(?string $route = null): \CodeIgniter\HTTP\RedirectResponse
    {
        $response = service('redirectresponse');

        if ((string) $route !== '') {
            $response->to($route)->send();
            exit;
        }

        return $response;
    }
}
