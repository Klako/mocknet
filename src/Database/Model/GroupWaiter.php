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
    private $id;

    /**
     * @ManyToOne(targetEntity="Group")
     * @var Group
     */
    private $group;

    /**
     * @ManyToOne(targetEntity="Member", inversedBy="groupWaits")
     * @var Member
     */
    private $member;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    private $waitingSince;
}