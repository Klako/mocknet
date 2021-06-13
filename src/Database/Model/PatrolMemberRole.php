<?php

namespace Scouterna\Mocknet\Database\Model;

use Faker\Generator;

/**
 * @Entity
 */
class PatrolMemberRole
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @OneToOne(targetEntity="PatrolMember")
     * @var PatrolMember
     */
    private $patrolMember;

    /**
     * @OneToOne(targetEntity="PatrolRole")
     * @var PatrolRole
     */
    private $role;
}