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
    public $id;

    /**
     * @Column
     * @var string
     */
    public $first_name;

    /**
     * @Column
     * @var string
     */
    public $last_name;

    /**
     * @Column
     * @var string
     */
    public $ssno;

    /**
     * @Column
     * @var string
     */
    public $note;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    public $date_of_birth;

    /**
     * @ManyToOne(targetEntity="Status")
     * @var Status
     */
    public $status;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    public $created_at;

    /**
     * @ManyToOne(targetEntity="Sex")
     * @var Sex
     */
    public $sex;

    /**
     * @Column
     * @var string
     */
    public $address_1;

    /**
     * @Column
     * @var string
     */
    public $postcode;

    /**
     * @Column
     * @var string
     */
    public $town;

    /**
     * @Column
     * @var string
     */
    public $country;

    /**
     * @Column
     * @var string
     */
    public $email;

    /**
     * @Column
     * @var string
     */
    public $contact_alt_email;

    /**
     * @Column
     * @var string
     */
    public $contact_mobile_phone;

    /**
     * @Column
     * @var string
     */
    public $contact_home_phone;

    /**
     * @Column
     * @var string
     */
    public $contact_mothers_name;

    /**
     * @Column
     * @var string
     */
    public $contact_email_mum;

    /**
     * @Column
     * @var string
     */
    public $contact_mobile_mum;

    /**
     * @Column
     * @var string
     */
    public $contact_telephone_mum;

    /**
     * @Column
     * @var string
     */
    public $contact_fathers_name;

    /**
     * @Column
     * @var string
     */
    public $contact_email_dad;

    /**
     * @Column
     * @var string
     */
    public $contact_mobile_dad;

    /**
     * @Column
     * @var string
     */
    public $contact_telephone_dad;

    /**
     * @Column
     * @var string
     */
    public $contact_leader_interest;

    /**
     * @OneToMany(targetEntity="GroupMember", mappedBy="member")
     * @var ArrayCollection|GroupMember[]
     */
    public $groupMembers;

    /**
     * @OneToMany(targetEntity="GroupWaiter", mappedBy="member")
     * @var ArrayCollection|GroupWaiter[]
     */
    public $groupWaits;

    public function __construct()
    {
        $this->groupMembers = new ArrayCollection();
        $this->groupWaits = new ArrayCollection();
    }
}
