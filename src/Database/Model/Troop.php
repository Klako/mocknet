<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Faker\Generator;
use Scouterna\Mocknet\Util\Helper;

/**
 * @Entity
 */
class Troop
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    public $id;

    /**
     * @Column
     * @var string
     */
    public $name;

    /**
     * @ManyToOne(targetEntity="ScoutGroup", inversedBy="troops")
     * @var ScoutGroup
     */
    public $group;

    /**
     * @OneToMany(targetEntity="Patrol", mappedBy="troop")
     * @var ArrayCollection|Patrol[]
     */
    public $patrols;

    /**
     * @OneToMany(targetEntity="GroupMember", mappedBy="troop")
     * @var ArrayCollection|GroupMember[]
     */
    public $members;

    /**
     * @OneToMany(targetEntity="TroopMemberRole", mappedBy="troop")
     * @var ArrayCollection|TroopMemberRole[]
     */
    public $memberRoles;

    public function __construct(ScoutGroup $group, $mock = true)
    {
        $this->patrols = new ArrayCollection();
        $this->members = new ArrayCollection();
        $this->memberRoles = new ArrayCollection();
        $this->group = $group;
        $group->troops->add($this);
        if ($mock){
            $faker = Helper::getFaker();
            $this->name = $faker->troopName;
        }
    }
}