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
     * @ManyToOne(targetEntity="Troop", inversedBy="members")
     * @var Troop
     */
    public $troop;

    /**
     * @OneToMany(targetEntity="TroopMemberRole", mappedBy="member")
     * @var ArrayCollection|TroopMemberRole[]
     */
    public $troopRoles;

    /**
     * @ManyToOne(targetEntity="Patrol", inversedBy="members")
     * @var Patrol
     */ 
    public $patrol;

    /**
     * @OneToMany(targetEntity="PatrolMemberRole", mappedBy="member")
     * @var ArrayCollection|PatrolMemberRole[]
     */
    public $patrolRoles;

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
     * @Column(nullable=true)
     * @var string
     */
    public $contact_leader_interest;

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
        $this->troopRoles = new ArrayCollection();
        $this->patrolRoles = new ArrayCollection();
        if ($mock) {
            $faker = Helper::getFaker();
            $endDate = $member->created_at->add(new \DateInterval('P1Y'));
            $this->confirmedAt = $faker->dateTimeBetween($member->created_at, $endDate);
            $this->contact_leader_interest = Helper::random($faker, 'boolean', 5);
        }
        $this->group = $group;
        $group->members->add($this);
        $this->member = $member;
        $member->groupMembers->add($this);
    }
}
