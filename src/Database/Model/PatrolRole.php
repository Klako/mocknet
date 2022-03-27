<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Faker\Generator;
use Scouterna\Mocknet\Util\Helper;

/**
 * @Entity
 */
class PatrolRole
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
     * @Column
     * @var string
     */
    public $key;

    /**
     * @ManyToMany(targetEntity="TroopMember", inversedBy="roles")
     * @var ArrayCollection|TroopMember[]
     */
    public $troopMembers;

    /**
     * @param bool $faker
     */
    public function __construct($mock = true)
    {
        $this->troopMembers = new ArrayCollection();
        if ($mock) {
            $faker = Helper::getFaker();
            $this->name = $faker->patrolRole;
            $this->key = Helper::keyify($this->name);
        }
    }
}
