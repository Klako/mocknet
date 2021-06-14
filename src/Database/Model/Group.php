<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Faker\Generator;

/**
 * @Entity
 */
class Group
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
     * @Column(type="boolean")
     * @var bool
     */
    public $groupEmail;

    /**
     * @Column
     * @var string
     */
    public $email;

    /**
     * @Column
     * @var string
     */
    public $description;

    /**
     * @OneToOne(targetEntity="GroupMember")
     * @var GroupMember
     */
    public $leader;

    /**
     * @OneToMany(targetEntity="CustomList", mappedBy="group")
     * @var ArrayCollection|CustomList[]
     */
    public $customLists;

    /**
     * @OneToMany(targetEntity="GroupMember", mappedBy="group")
     * @var ArrayCollection|GroupMember[]
     */
    public $members;

    /**
     * @OneToMany(targetEntity="GroupWaiter", mappedBy="group")
     * @var ArrayCollection|GroupWaiter[]
     */
    public $waiters;

    /**
     * @OneToMany(targetEntity="Troop", mappedBy="group")
     * @var ArrayCollection|Troop[]
     */
    public $troops;

    public function __construct()
    {
        $this->customLists = new ArrayCollection();
        $this->members = new ArrayCollection();
        $this->waiters = new ArrayCollection();
        $this->troops = new ArrayCollection();
    }
}
