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
    private $id;

    /**
     * @Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @ManyToMany(targetEntity="GroupMember", inversedBy="roles")
     * @var ArrayCollection|GroupMember[]
     */
    private $groupMembers;

    public function __construct()
    {
        $this->groupMembers = new ArrayCollection();
    }
}