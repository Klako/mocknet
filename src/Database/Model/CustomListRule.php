<?php

namespace Scouterna\Mocknet\Database\Model;

use Faker\Generator;

/**
 * @Entity
 */
class CustomListRule
{
    /**
     * @Id
     * @Column(type="integer")
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