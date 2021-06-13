<?php

namespace Scouterna\Mocknet\Database\Model;

use Faker\Generator;

/**
 * @Entity
 */
class CustomListRuleMember
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="CustomListRule", inversedBy="members")
     * @var CustomListRule
     */
    private $customListRule;

    /**
     * @OneToOne(targetEntity="GroupMember")
     * @var GroupMember
     */
    private $member;
}