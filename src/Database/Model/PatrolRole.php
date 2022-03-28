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
     * @OneToMany(targetEntity="PatrolMemberRole", mappedBy="roles")
     * @var ArrayCollection|PatrolMemberRole[]
     */
    public $patrolMembers;

    /**
     * @param bool $faker
     */
    public function __construct($mock = true)
    {
        $this->patrolMembers = new ArrayCollection();
        if ($mock) {
            $faker = Helper::getFaker();
            $this->name = $faker->patrolRole;
            $this->key = Helper::keyify($this->name);
        }
    }
}
