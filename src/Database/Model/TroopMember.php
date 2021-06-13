<?php

namespace Scouterna\Mocknet\Database\Model;

use Faker\Generator;

/**
 * @Entity
 */
class TroopMember
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Troop")
     * @var Troop
     */
    private $troop;

    /**
     * @OneToOne(targetEntity="Member")
     * @var Member
     */
    private $member;
}