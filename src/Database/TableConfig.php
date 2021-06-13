<?php

namespace Scouterna\Mocknet\Database;

use Faker\Generator;

abstract class TableConfig
{
    /** @var Generator */
    protected $faker;

    private $amount;

    public function __construct(Generator $faker, int $amount)
    {
        $this->faker = $faker;
        $this->amount = $amount;
    }

    public function setAmount(int $amount)
    {
        $this->amount = $amount;
        $this->firstName = new Field;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function generate()
    {
        $sql = "";
        for ($i = 0; $i < $this->amount; $i++) {
            $sql .= $this->getRowValues() . ';';
        }
        return $sql;
    }

    public static abstract function getTableSql();

    public static abstract function getRowCols();

    protected abstract function getRowValues();
}
