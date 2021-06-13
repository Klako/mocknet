<?php

namespace Scouterna\Mocknet\Database;

use Faker\Generator;

/**
 * @Entity
 * @Table("groups")
 */
class Group
{
    /**
     * @Id
     * @Column(type="id")
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @Column(name="group_email", type="boolean")
     * @var bool
     */
    private $groupEmail;

    /**
     * @Column(type="string")
     * @var string
     */
    private $email;

    /**
     * @Column(type="string")
     * @var string
     */
    private $description;

    /**
     * @OneToOne(targetEntity="Member")
     * @var int
     */
    private $leader;
}
