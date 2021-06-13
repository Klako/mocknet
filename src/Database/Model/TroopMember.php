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
    private $id;

    /**
     * @ManyToOne(targetEntity="Troop", inversedBy="members")
     * @var Troop
     */
    private $troop;

    /**
     * @ManyToOne(targetEntity="GroupMember", inversedBy="troops")
     * @var GroupMember
     */
    private $member;

    /**
     * @ManyToMany(targetEntity="TroopRole", mappedBy="troopMembers")
     * @var ArrayCollection|TroopRole[]
     */
    private $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }
}