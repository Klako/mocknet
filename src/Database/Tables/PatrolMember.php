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
        CREATE TABLE "patrolmembers" (
        	"id"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        	"patrol"	INTEGER NOT NULL,
        	"member"	INTEGER NOT NULL,
        	UNIQUE("patrol","member")
        );
        SQL;
    }
}