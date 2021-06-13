<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Faker\Generator;

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
    private $id;

    /**
     * @Column
     * @var string
     */
    private $name;

    /**
     * @ManyToOne(targetEntity="Group", inversedBy="troops")
     * @var Group
     */
    private $group;

    /**
     * @OneToMany(targetEntity="TroopMember", mappedBy="troop")
     * @var ArrayCollection|TroopMember[]
     */
    private $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }
}