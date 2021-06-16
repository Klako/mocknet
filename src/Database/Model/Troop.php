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
     * @ManyToOne(targetEntity="Group", inversedBy="troops")
     * @var Group
     */
    public $group;

    /**
     * @OneToMany(targetEntity="TroopMember", mappedBy="troop")
     * @var ArrayCollection|TroopMember[]
     */
    public $members;

    public function __construct(Group $group, $mock = true)
    {
        $this->members = new ArrayCollection();
        $this->group = $group;
        $group->troops->add($this);
        if ($mock){
            $faker = Helper::getFaker();
            $this->name = $faker->troopName;
        }
    }
}