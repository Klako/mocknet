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
        CREATE TABLE "customlists" (
        	"id"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        	"title"	TEXT NOT NULL,
        	"description"	TEXT NOT NULL,
        	"group"	INTEGER NOT NULL
        );
        SQL;
    }
}