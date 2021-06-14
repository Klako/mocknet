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
    public $id;

    /**
     * @ManyToOne(targetEntity="CustomListRule", inversedBy="members")
     * @var CustomListRule
     */
    public $customListRule;

    /**
     * @OneToOne(targetEntity="GroupMember")
     * @var GroupMember
     */
    public $member;
}