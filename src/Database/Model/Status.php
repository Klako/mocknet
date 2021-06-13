<?php

namespace Scouterna\Mocknet\Database\Model;

use Faker\Generator;

/**
 * @Entity
 */
class Status
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @Column
     * @var string
     */
    private $value;
}