<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Faker\Generator;

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
     * @ManyToMany(targetEntity="PatrolMember", inversedBy="roles")
     * @var ArrayCollection|PatrolMember[]
     */
    public $patrolMembers;

    public function __construct()
    {
        $this->patrolMembers = new ArrayCollection();
    }
}