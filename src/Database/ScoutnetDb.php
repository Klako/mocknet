<?php

namespace Scouterna\Mocknet\Database;

class ScoutnetDb
{
    private $file;

    private function __construct($file)
    {
        $this->file = $file;
    }

    public function load(string $file)
    {
        if (!\file_exists($file)) {
            return false;
        }
    }

    public function create(string $file)
    {
        if (\file_exists($file)) {
            return false;
        }
    }

    private function clear()
    {

    }

    public function populate($config)
    {
        $this->clear();
    }
}
