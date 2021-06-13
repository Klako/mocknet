<?php

namespace Scouterna\Mocknet\Database;

use Faker\Generator;

class Sex extends TableConfig
{
    public function __construct(Generator $faker)
    {
        parent::__construct($faker, 2);
    }

    public static function getRowCols()
    {
        
    }

    protected function getRowValues()
    {
        
    }

    public static function getTableSql()
    {
        return <<<SQL
        CREATE TABLE "grouproles" (
        	"id"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        	"name"	TEXT NOT NULL
        );
        SQL;
    }
}