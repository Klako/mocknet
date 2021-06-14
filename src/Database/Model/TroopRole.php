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
    public $id;

    /**
     * @Column
     * @var string
     */
    public $name;

    /**
     * @ManyToMany(targetEntity="TroopMember", inversedBy="roles")
     * @var ArrayCollection|TroopMember[]
     */
    public $troopMembers;

    public function __construct()
    {
        $this->troopMembers = new ArrayCollection();
    }
}