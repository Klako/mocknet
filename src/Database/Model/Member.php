<?php

namespace Scouterna\Mocknet\Database\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Scouterna\Mocknet\Util\Helper;

/**
 * @Entity
 */
class Member
{
    public const SEX_UNKNOWN = ['raw_value' => 0, 'value' => 'Okänt'];
    public const SEX_MALE = ['raw_value' => 1, 'value' => 'Man'];
    public const SEX_FEMALE = ['raw_value' => 2, 'value' => 'Kvinna'];
    public const SEX_OTHER = ['raw_value' => 3, 'value' => 'Annat'];
    public const SEX_ARRAY = [
        self::SEX_UNKNOWN['raw_value'] => self::SEX_UNKNOWN,
        self::SEX_MALE['raw_value'] => self::SEX_MALE,
        self::SEX_FEMALE['raw_value'] => self::SEX_FEMALE,
        self::SEX_OTHER['raw_value'] => self::SEX_OTHER
    ];

    public const STATUS_DUNNO = ['raw_value' => 1, 'value' => 'Vet inte'];
    public const STATUS_ACTIVE = ['raw_value' => 2, 'value' => 'Aktiv'];
    public const STATUS_DUNNO2 = ['raw_value' => 3, 'value' => 'Vet inte 2'];
    public const STATUS_NEW = ['raw_value' => 4, 'value' => 'Ny'];
    public const STATUS_ARRAY = [
        self::STATUS_DUNNO['raw_value'] => self::STATUS_DUNNO,
        self::STATUS_ACTIVE['raw_value'] => self::STATUS_ACTIVE,
        self::STATUS_DUNNO2['raw_value'] => self::STATUS_DUNNO2,
        self::STATUS_NEW['raw_value'] => self::STATUS_NEW,
    ];

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
     * @Column(type="integer")
     * @var int
     */
    public $status;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    public $created_at;

    /**
     * @Column(type="integer")
     * @var int
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

    /**
     * @param \Faker\Generator $faker
     */
    public function __construct($mock = true)
    {
        $this->groupMembers = new ArrayCollection();
        $this->groupWaits = new ArrayCollection();
        if ($mock) {
            $faker = Helper::getFaker();
            $this->first_name = $faker->firstName;
            $this->last_name = $faker->lastName;
            $this->note = $this->random($faker, 'sentence', 3);
            $this->date_of_birth = $faker->dateTimeBetween('-40 years', '-8 years');
            $this->sex = $faker->randomElement(self::SEX_ARRAY)['raw_value'];
            $this->status = $faker->randomElement(self::STATUS_ARRAY)['raw_value'];
            $this->ssno = $faker->personalIdentityNumber($this->date_of_birth);
            $this->address_1 = $faker->streetAddress;
            $this->postcode = $faker->postcode;
            $this->town = $faker->city;
            $this->country = 'Sverige';
            $this->email = $faker->safeEmail;
            $this->contact_alt_email = $this->random($faker, 'safeEmail', 5);
            $this->contact_mobile_phone = $this->random($faker, 'phoneNumber', 5);
            $this->contact_home_phone = $this->random($faker, 'phoneNumber', 5);
            $this->contact_mothers_name = $this->random($faker, 'name', 5);
            $this->contact_mobile_mum = $this->random($faker, 'phoneNumber', 5);
            $this->contact_telephone_mum = $this->random($faker, 'phoneNumber', 5);
            $this->contact_email_mum = $this->random($faker, 'safeEmail', 5);
            $this->contact_fathers_name = $this->random($faker, 'name', 5);
            $this->contact_mobile_dad = $this->random($faker, 'phoneNumber', 5);
            $this->contact_telephone_dad = $this->random($faker, 'phoneNumber', 5);
            $this->contact_email_dad = $this->random($faker, 'safeEmail', 5);
            $this->contact_leader_interest = $this->random($faker, 'boolean', 5);
        }
    }

    private function random($faker, $field, $chance)
    {
        return $faker->randomDigit < $chance ? $faker->{$field} : null;
    }
}
