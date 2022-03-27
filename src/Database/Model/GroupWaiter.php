<?php

namespace Scouterna\Mocknet\Database\Model;

use Faker\Generator;
use Scouterna\Mocknet\Util\Helper;

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
     * @ManyToOne(targetEntity="ScoutGroup", inversedBy="waiters")
     * @var ScoutGroup
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
     * @Column(nullable=true)
     * @var string
     */
    public $contact_leader_interest;

    /**
     * @param ScoutGroup $group
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
            $faker = Helper::getFaker();
            $this->waitingSince = clone $member->created_at;
            $this->contact_leader_interest = Helper::random($faker, 'boolean', 5);
        }
    }
}
