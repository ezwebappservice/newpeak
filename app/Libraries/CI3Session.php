<?php

namespace App\Libraries;

/**
 * CodeIgniter 3 style session userdata access for views.
 */
class CI3Session
{
    public function userdata(?string $key = null)
    {
        if ($key === null) {
            return session()->get() ?? [];
        }

        return session()->get($key);
    }

    public function set_userdata($data, $value = null): void
    {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                session()->set($k, $v);
            }

            return;
        }

        session()->set($data, $value);
    }

    public function unset_userdata($key): void
    {
        session()->remove($key);
    }
}
