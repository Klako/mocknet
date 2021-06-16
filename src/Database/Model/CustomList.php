<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Faker\Generator;
use Scouterna\Mocknet\Util\Helper;
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

    /**
     * @param bool $mock
     * @param Group $group
     */
    public function __construct($group, $mock = true)
    {
        $this->rules = new ArrayCollection();
        if ($mock) {
            $faker = Helper::getFaker();
            $this->title = "{$faker->domainWord} list";
            $this->description = $faker->sentence;
        }
        $this->group = $group;
        $group->customLists->add($this);
    }
}
