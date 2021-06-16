<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Faker\Generator;
use Scouterna\Mocknet\Util\Helper;

/**
 * @Entity
 */
class GroupRole
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    public $id;

    /**
     * @Column(type="string")
     * @var string
     */
    public $name;

    /**
     * @Column
     * @var string
     */
    public $key;

    /**
     * @ManyToMany(targetEntity="GroupMember", inversedBy="roles")
     * @var ArrayCollection|GroupMember[]
     */
    public $groupMembers;

    /**
     * @param bool $faker
     */
    public function __construct($mock = true)
    {
        $this->groupMembers = new ArrayCollection();
        if ($mock) {
            $faker = Helper::getFaker();
            $this->name = $faker->groupRole;
            $this->key = Helper::keyify($this->name);
        }
    }
}
