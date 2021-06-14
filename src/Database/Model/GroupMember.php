<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;

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
     * @ManyToOne(targetEntity="Group", inversedBy="members")
     * @var Group
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
     * @ManyToMany(targetEntity="GroupMemberRole", mappedBy="groupMembers")
     * @var ArrayCollection|GroupRole[]
     */
    public $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->customListRules = new ArrayCollection();
    }
}