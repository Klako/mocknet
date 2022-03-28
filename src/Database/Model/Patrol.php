<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Faker\Generator;
use Scouterna\Mocknet\Util\Helper;
use Scouterna\Mocknet\Organisation;

/**
 * @Entity
 */
class Patrol
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
     * @ManyToOne(targetEntity="Troop", inversedBy="patrols")
     * @var Troop
     */
    public $troop;

    /**
     * @OneToMany(targetEntity="GroupMember", mappedBy="patrol")
     * @var ArrayCollection|GroupMember[]
     */
    public $members;

    /**
     * @OneToMany(targetEntity="PatrolMemberRole", mappedBy="patrol")
     * @var ArrayCollection|PatrolMemberRole[]
     */
    public $memberRoles;

    public function __construct(Troop $troop, $mock = true)
    {
        $this->members = new ArrayCollection();
        $this->memberRoles = new ArrayCollection();
        $this->troop = $troop;
        $troop->patrols->add($this);
        if ($mock){
            $faker = Helper::getFaker();
            $this->name = $faker->patrolName;
        }
    }
}
