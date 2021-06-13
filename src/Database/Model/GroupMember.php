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
    private $id;

    /**
     * @ManyToOne(targetEntity="Group", inversedBy="members")
     * @var Group
     */
    private $group;

    /**
     * @ManyToOne(targetEntity="Member", inversedBy="groupMembers")
     * @var Member
     */
    private $member;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    private $confirmedAt;

    /**
     * @ManyToMany(targetEntity="GroupMemberRole", mappedBy="groupMembers")
     * @var ArrayCollection|GroupRole[]
     */
    private $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }
}