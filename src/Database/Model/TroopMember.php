<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ManyToOne(targetEntity="Patrol", inversedBy="members")
     * @var Patrol
     */
    public $patrol;

    /**
     * @ManyToMany(targetEntity="PatrolRole", mappedBy="troopMembers")
     * @var ArrayCollection|PatrolRole[]
     */
    public $patrolRoles;

    /**
     * @ManyToMany(targetEntity="TroopRole", mappedBy="troopMembers")
     * @var ArrayCollection|TroopRole[]
     */
    public $roles;

    public function __construct(Troop $troop, GroupMember $member)
    {
        $this->roles = new ArrayCollection();
        $this->patrolRoles = new ArrayCollection();
        $this->troop = $troop;
        $troop->members->add($this);
        $this->member = $member;
        $member->troops->add($this);
    }

    public function addRole(TroopRole $role)
    {
        $this->roles->add($role);
        $role->troopMembers->add($this);
    }

    public function setPatrol(Patrol $patrol) {
        if ($this->patrol !== null) {
            $this->patrol->members->removeElement($this);
        }
        $this->patrol = $patrol;
        if ($patrol !== null) {
            $patrol->members->add($this);
        }
    }
}
