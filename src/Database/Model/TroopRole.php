<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Faker\Generator;

/**
 * @Entity
 */
class TroopRole
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
     * @ManyToMany(targetEntity="TroopMember", inversedBy="roles")
     * @var ArrayCollection|TroopMember[]
     */
    private $troopMembers;

    public function __construct()
    {
        $this->troopMembers = new ArrayCollection();
    }
}