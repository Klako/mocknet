<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Faker\Generator;

/**
 * @Entity
 */
class CustomList
{
    /**
     * @Id
     * @Column(name="id", type="integer")
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
     * @Column(name="description", type="string")
     * @var string
     */
    public $description;

    /**
     * @ManyToOne(targetEntity="Group", inversedBy="customLists")
     * @var Group
     */
    public $group;

    /**
     * @OneToMany(targetEntity="CustomListRule",mappedBy="customList")
     * @var ArrayCollection<CustomListRule>
     */
    public $rules;

    public function __construct()
    {
        $this->rules = new ArrayCollection();
    }
}