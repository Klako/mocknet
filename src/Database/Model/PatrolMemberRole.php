<?php

namespace Scouterna\Mocknet\Database\Model;

use Faker\Generator;

/**
 * @Entity
 */
class PatrolMemberRole
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    public $id;

    /**
     * @ManyToOne(targetEntity="Patrol", inversedBy="members")
     * @var Patrol
     */
    public $troop;

    /**
     * @ManyToOne(targetEntity="GroupMember", inversedBy="troops")
     * @var GroupMember
     */
    public $member;

    /**
     * @ManyToMany(targetEntity="PatrolRole", mappedBy="patrolMembers")
     * @var PatrolRole
     */
    public $role;

    public function __construct(Troop $troop, GroupMember $member, PatrolRole $role)
    {
        $this->troop = $troop;
        $troop->members->add($this);
        $this->member = $member;
        $member->troops->add($this);
        $this->role = $role;
        $role->patrolMembers->add($this);
    }
}
