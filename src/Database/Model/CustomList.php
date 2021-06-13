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
    private $id;

    /**
     * @Column(name="title", type="string")
     * @var string
     */
    private $title;

    /**
     * @Column(name="description", type="string")
     * @var string
     */
    private $description;

    /**
     * @ManyToOne(targetEntity="Group", inversedBy="customLists")
     * @var Group
     */
    private $group;

    /**
     * @OneToMany(targetEntity="CustomListRule",mappedBy="customList")
     * @var ArrayCollection<CustomListRule>
     */
    private $rules;

    public function __construct()
    {
        $this->rules = new ArrayCollection();
    }
}
