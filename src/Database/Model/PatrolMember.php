<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Faker\Generator;
use Scouterna\Mocknet\Util\Helper;

/**
 * @Entity
 */
class PatrolMember
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    public $id;

    /**
     * @ManyToOne(targetEntity="Patrol")
     * @var Patrol
     */
    public $patrol;

    /**
     * @ManyToOne(targetEntity="GroupMember", inversedBy="patrols")
     * @var GroupMember
     */
    public $member;

    /**
     * @ManyToMany(targetEntity="PatrolRole", mappedBy="patrolMembers")
     * @var ArrayCollection|PatrolRole[]
     */
    public $roles;

    public function __construct(Patrol $patrol, GroupMember $member)
    {
        $this->roles = new ArrayCollection();
        $this->patrol = $patrol;
        $patrol->members->add($this);
        $this->member = $member;
        $member->patrols->add($this);
    }

    public function addRole(PatrolRole $patrolRole)
    {
        $this->roles->add($patrolRole);
        $patrolRole->patrolMembers->add($this);
    }
}
