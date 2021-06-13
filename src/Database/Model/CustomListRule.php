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
    private $id;

    /**
     * @Column(name="title", type="string")
     * @var string
     */
    private $title;

    /**
     * @ManyToOne(targetEntity="CustomList", inversedBy="rules")
     * @var CustomList
     */
    private $customList;

    /**
     * @OneToMany(targetEntity="CustomListRuleMember", mappedBy="customListRule")
     * @var ArrayCollection<CustomListRuleMember>
     */
    private $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }
}