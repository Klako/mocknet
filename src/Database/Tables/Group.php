<?php

namespace Scouterna\ScoutnetMock\Database;

use Faker\Generator;

class Group extends TableConfig
{
    public function __construct(Generator $faker)
    {
        parent::__construct($faker, 1);
    }

    public static function getRowCols()
    {
        return [
            'name',
            'group_email',
            'email',
            'description',
            'leader'
        ];
    }

    protected function getRowValues()
    {
        return [
            'name' => $this->faker->company,
            'group_email' => true,
            'email' => $this->faker->email,
            'description' => $this->faker->text,
            'leader' => null
        ];
    }

    public static function getTableSql()
    {
        return <<<SQL
        CREATE TABLE "groups" (
	        "id"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	        "name"	TEXT NOT NULL,
	        "group_email"	BOOLEAN NOT NULL,
	        "email"	TEXT NOT NULL DEFAULT "",
	        "description"	TEXT NOT NULL DEFAULT "",
	        "leader"	INTEGER,
        );
        SQL;
    }
}
