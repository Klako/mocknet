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
     * @ManyToMany(targetEntity="CustomListRule", inversedBy="members")
     * @var CustomListRule
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