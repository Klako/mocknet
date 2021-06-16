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
     * @OneToMany(targetEntity="PatrolMember", mappedBy="patrol")
     * @var ArrayCollection|PatrolMember[]
     */
    public $members;

    public function __construct(Troop $troop, $mock = true)
    {
        $this->members = new ArrayCollection();
        $this->troop = $troop;
        $troop->patrols->add($this);
        if ($mock){
            $faker = Helper::getFaker();
            $this->name = $faker->patrolName;
        }
    }
}
