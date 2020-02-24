<?php

namespace Scouterna\ScoutnetMock\Database;

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
        CREATE TABLE "patrolmemberroles" (
        	"id"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        	"patrolmember"	INTEGER NOT NULL,
        	"role"	INTEGER NOT NULL,
        	UNIQUE("patrolmember","role")
        );
        SQL;
    }
}