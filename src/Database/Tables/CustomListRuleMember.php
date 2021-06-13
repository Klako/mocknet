<?php

namespace Scouterna\Mocknet\Database;

use Faker\Generator;

/**
 * @Entity
 * @Table(name="customlistrilemembers")
 */
class CustomListRuleMember
{
    /**
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ManyToOne()
     * @var int
     */
    private $customListRule;

    private $member;

    public static function getTableSql()
    {
        return <<<SQL
        CREATE TABLE "customlistrulemembers" (
        	"id"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        	"customlistrule"	INTEGER NOT NULL,
        	"member"	INTEGER NOT NULL,
        	UNIQUE("customlistrule","member")
        );
        SQL;
    }
}