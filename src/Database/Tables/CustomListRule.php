<?php

namespace Scouterna\Mocknet\Database;

use Faker\Generator;

/**
 * @Entity
 * @Table("customlistrules")
 */
class CustomListRule
{
    /**
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @Column(name="title", type="string")
     * @var string
     */
    private $title;

    /**
     * @ManyToOne(targetEntity="CustomList")
     * @var CustomList
     */
    private $customlist;
}