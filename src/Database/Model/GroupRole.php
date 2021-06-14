<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Faker\Generator;

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
     * @ManyToMany(targetEntity="GroupMember", inversedBy="roles")
     * @var ArrayCollection|GroupMember[]
     */
    public $groupMembers;

    public function __construct()
    {
        $this->groupMembers = new ArrayCollection();
    }
}