<?php

namespace Scouterna\Mocknet\Database\Model;

use Faker\Generator;

/**
 * @Entity
 */
class CustomList
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
     * @Column(name="description", type="string")
     * @var string
     */
    private $description;

    /**
     * @Column(name="group", type="integer")
     * @var int
     */
    private $group;
}