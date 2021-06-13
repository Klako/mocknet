<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Faker\Generator;

/**
 * @Entity
 */
class Member
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @Column
     * @var string
     */
    private $first_name;

    /**
     * @Column
     * @var string
     */
    private $last_name;

    /**
     * @Column
     * @var string
     */
    private $ssno;

    /**
     * @Column
     * @var string
     */
    private $note;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    private $date_of_birth;

    /**
     * @ManyToOne(targetEntity="Status")
     * @var Status
     */
    private $status;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    private $created_at;

    /**
     * @ManyToOne(targetEntity="Sex")
     * @var Sex
     */
    private $sex;

    /**
     * @Column
     * @var string
     */
    private $address_1;

    /**
     * @Column
     * @var string
     */
    private $postcode;

    /**
     * @Column
     * @var string
     */
    private $town;

    /**
     * @Column
     * @var string
     */
    private $country;

    /**
     * @Column
     * @var string
     */
    private $email;

    /**
     * @Column
     * @var string
     */
    private $contact_alt_email;

    /**
     * @Column
     * @var string
     */
    private $contact_mobile_phone;

    /**
     * @Column
     * @var string
     */
    private $contact_home_phone;

    /**
     * @Column
     * @var string
     */
    private $contact_mothers_name;

    /**
     * @Column
     * @var string
     */
    private $contact_email_mum;

    /**
     * @Column
     * @var string
     */
    private $contact_mobile_mum;

    /**
     * @Column
     * @var string
     */
    private $contact_telephone_mum;

    /**
     * @Column
     * @var string
     */
    private $contact_fathers_name;

    /**
     * @Column
     * @var string
     */
    private $contact_email_dad;

    /**
     * @Column
     * @var string
     */
    private $contact_mobile_dad;

    /**
     * @Column
     * @var string
     */
    private $contact_telephone_dad;

    /**
     * @Column
     * @var string
     */
    private $contact_leader_interest;

    /**
     * @OneToMany(targetEntity="GroupMember", mappedBy="member")
     * @var ArrayCollection|GroupMember[]
     */
    private $groupMembers;

    /**
     * @OneToMany(targetEntity="GroupWaiter", mappedBy="member")
     * @var ArrayCollection|GroupWaiter[]
     */
    private $groupWaits;

    public function __construct()
    {
        $this->groupMembers = new ArrayCollection();
        $this->groupWaits = new ArrayCollection();
    }
}
