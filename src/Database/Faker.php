<?php

namespace Scouterna\Mocknet\Database;

use Faker\Factory;

class Faker
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

}