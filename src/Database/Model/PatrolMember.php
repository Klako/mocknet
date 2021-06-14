<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Faker\Generator;

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

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }
}