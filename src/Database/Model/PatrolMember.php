<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ManyToOne(targetEntity="GroupMember", inversedBy="patrols")
     * @var GroupMember
     */
    private $member;

    /**
     * @ManyToMany(targetEntity="PatrolRole", mappedBy="patrolMembers")
     * @var ArrayCollection|PatrolRole[]
     */
    private $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }
}