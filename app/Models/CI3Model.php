<?php

namespace App\Models;

class CI3Model
{
    /** @var \App\Libraries\CI3Database */
    protected $db;

    public function __construct()
    {
        $this->db = new \App\Libraries\CI3Database();
    }
}
