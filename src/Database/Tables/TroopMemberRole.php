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
        CREATE TABLE "troopmemberroles" (
        	"id"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        	"troopmember"	INTEGER NOT NULL,
        	"role"	INTEGER NOT NULL,
        	UNIQUE("troopmember","role")
        );
        SQL;
    }
}