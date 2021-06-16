<?php

namespace Scouterna\Mocknet\Database\Model;

use Faker\Generator;

/**
 * @Entity
 */
class GroupWaiter
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    public $id;

    /**
     * @ManyToOne(targetEntity="Group", inversedBy="waiters")
     * @var Group
     */
    public $group;

    /**
     * @ManyToOne(targetEntity="Member", inversedBy="groupWaits")
     * @var Member
     */
    public $member;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    public $waitingSince;

    /**
     * @param Group $group
     * @param Member $member
     * @param bool $faker
     */
    public function __construct($group, $member, $mock = true)
    {
        $this->group = $group;
        $group->waiters->add($this);
        $this->member = $member;
        $member->groupWaits->add($this);
        if ($mock) {
            $this->waitingSince = clone $member->created_at;
        }
    }
}
