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
    private $id;

    /**
     * @Column
     * @var string
     */
    private $name;

    /**
     * @Column(type="boolean")
     * @var bool
     */
    private $groupEmail;

    /**
     * @Column
     * @var string
     */
    private $email;

    /**
     * @Column
     * @var string
     */
    private $description;

    /**
     * @OneToOne(targetEntity="GroupMember")
     * @var GroupMember
     */
    private $leader;

    /**
     * @OneToMany(targetEntity="CustomList", mappedBy="group")
     * @var ArrayCollection|CustomList[]
     */
    private $customLists;

    /**
     * @OneToMany(targetEntity="GroupMember", mappedBy="group")
     * @var ArrayCollection|GroupMember[]
     */
    private $members;

    /**
     * @OneToMany(targetEntity="Troop", mappedBy="group")
     * @var ArrayCollection|Troop[]
     */
    private $troops;

    public function __construct()
    {
        $this->customLists = new ArrayCollection();
        $this->members = new ArrayCollection();
        $this->troops = new ArrayCollection();
    }
}
