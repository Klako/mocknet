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
    private $id;

    /**
     * @Column
     * @var string
     */
    private $name;

    /**
     * @ManyToMany(targetEntity="PatrolMember", inversedBy="roles")
     * @var ArrayCollection|PatrolMember[]
     */
    private $patrolMembers;

    public function __construct()
    {
        $this->patrolMembers = new ArrayCollection();
    }
}