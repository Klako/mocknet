<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Scouterna\Mocknet\Util\Helper;

/**
 * @Entity
 */
class GroupMember
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    public $id;

    /**
     * @ManyToOne(targetEntity="ScoutGroup", inversedBy="members")
     * @var ScoutGroup
     */
    public $group;

    /**
     * @OneToMany(targetEntity="TroopMember", mappedBy="member")
     * @var ArrayCollection|TroopMember[]
     */
    public $troops;

    /**
     * @OneToMany(targetEntity="PatrolMember", mappedBy="member")
     * @var ArrayCollection|PatrolMember[]
     */
    public $patrols;

    /**
     * @ManyToMany(targetEntity="CustomListRule", inversedBy="members")
     * @var ArrayCollection|CustomListRule[]
     */
    public $customListRules;

    /**
     * @ManyToOne(targetEntity="Member", inversedBy="groupMembers")
     * @var Member
     */
    public $member;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    public $confirmedAt;

    /**
     * @ManyToMany(targetEntity="GroupRole", mappedBy="groupMembers")
     * @var ArrayCollection|GroupRole[]
     */
    public $roles;

    /**
     * @param ScoutGroup $group 
     * @param Member $member 
     * @param bool $mock
     */
    public function __construct($group, $member, $mock = true)
    {
        $this->roles = new ArrayCollection();
        $this->customListRules = new ArrayCollection();
        $this->troops = new ArrayCollection();
        $this->patrols = new ArrayCollection();
        $this->customListRules = new ArrayCollection();
        if ($mock) {
            $faker = Helper::getFaker();
            $endDate = $member->created_at->add(new \DateInterval('P1Y'));
            $this->confirmedAt = $faker->dateTimeBetween($member->created_at, $endDate);
        }
        $this->group = $group;
        $group->members->add($this);
        $this->member = $member;
        $member->groupMembers->add($this);
    }
}
