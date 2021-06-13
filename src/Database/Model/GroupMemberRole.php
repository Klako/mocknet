<?php

namespace Scouterna\Mocknet\Database\Model;

use Faker\Generator;

/**
 * @Entity
 */
class GroupMemberRole
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @OneToOne(targetEntity="GroupMember")
     * @var GroupMember
     */
    private $groupMember;

    /**
     * @OneToOne(targetEntity="GroupRole")
     * @var GroupRole
     */
    private $role;
}