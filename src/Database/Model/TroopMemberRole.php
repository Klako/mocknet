<?php

namespace Scouterna\Mocknet\Database\Model;

use Faker\Generator;

/**
 * @Entity
 */
class TroopMemberRole
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="TroopMember")
     * @var TroopMember
     */
    private $troopMember;

    /**
     * @ManyToOne(targetEntity="TroopRole")
     * @var TroopRole
     */
    private $role;
}