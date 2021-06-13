<?php

namespace Scouterna\Mocknet\Database\Model;

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
     * @OneToOne(targetEntity="Group")
     * @var Group
     */
    private $group;

    /**
     * @OneToOne(targetEntity="Member")
     * @var Member
     */
    private $member;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    private $confirmedAt;

    /** UNIQUE group,member */
}