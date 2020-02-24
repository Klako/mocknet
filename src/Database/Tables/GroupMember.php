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
        CREATE TABLE "groupmembers" (
        	"id"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        	"group"	INTEGER NOT NULL,
        	"member"	INTEGER NOT NULL,
        	"confirmed_at"	TEXT NOT NULL,
        	UNIQUE("group","member")
        );
        SQL;
    }
}