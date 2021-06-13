<?php

namespace Scouterna\Mocknet\Database\Model;

use Faker\Generator;

/**
 * @Entity
 */
class Sex
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Patrol")
     * @var Patrol
     */
    private $patrol;

    /**
     * @OneToOne(targetEntity="GroupMember")
     * @var Member
     */
    private $member;
}