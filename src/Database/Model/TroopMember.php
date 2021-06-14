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
     * @ManyToMany(targetEntity="TroopRole", mappedBy="troopMembers")
     * @var ArrayCollection|TroopRole[]
     */
    public $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }
}