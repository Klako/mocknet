<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Faker\Generator;
use Scouterna\Mocknet\Util\Helper;

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
     * @ManyToMany(targetEntity="GroupMember", mappedBy="customListRules")
     * @var ArrayCollection|GroupMember[]
     */
    public $members;

    /**
     * @param Generator $mock
     * @param CustomList $list
     */
    public function __construct($list, $mock = true)
    {
        $this->members = new ArrayCollection();
        if ($mock) {
            $faker = Helper::getFaker();
            $this->title = "{$faker->domainWord} list rule";
        }
        $this->customList = $list;
        $list->rules->add($this);
    }
}
