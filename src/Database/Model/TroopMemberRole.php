<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;
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
    public $id;

    /**
     * @ManyToOne(targetEntity="Troop", inversedBy="members")
     * @var Troop
     */
    public $troop;

    /**
     * @ManyToOne(targetEntity="GroupMember", inversedBy="troops")
     * @var GroupMember
     */
    public $member;

    /**
     * @ManyToOne(targetEntity="TroopRole", inversedBy="troopMembers")
     * @var TroopRole
     */
    public $role;

    public function __construct(Troop $troop, GroupMember $member, TroopRole $role)
    {
        $this->troop = $troop;
        $troop->members->add($this);
        $this->member = $member;
        $member->troops->add($this);
        $this->role = $role;
        $role->troopMembers->add($this);
    }
}
