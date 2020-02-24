<?php

namespace Scouterna\ScoutnetMock\Database;

use Faker\Factory;

class Faker
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

}