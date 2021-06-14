<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Faker\Generator;

/**
 * @Entity
 */
class CustomListRule
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    public $id;

    /**
     * @Column(name="title", type="string")
     * @var string
     */
    public $title;

    /**
     * @ManyToOne(targetEntity="CustomList", inversedBy="rules")
     * @var CustomList
     */
    public $customList;

    /**
     * @OneToMany(targetEntity="CustomListRuleMember", mappedBy="customListRule")
     * @var ArrayCollection<CustomListRuleMember>
     */
    public $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }
}