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
    public $password;

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
     * @Column(nullable=true)
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
     * @Column(nullable=true)
     * @var string
     */
    public $contact_alt_email;

    /**
     * @Column(nullable=true)
     * @var string
     */
    public $contact_mobile_phone;

    /**
     * @Column(nullable=true)
     * @var string
     */
    public $contact_home_phone;

    /**
     * @Column(nullable=true)
     * @var string
     */
    public $contact_mothers_name;

    /**
     * @Column(nullable=true)
     * @var string
     */
    public $contact_email_mum;

    /**
     * @Column(nullable=true)
     * @var string
     */
    public $contact_mobile_mum;

    /**
     * @Column(nullable=true)
     * @var string
     */
    public $contact_telephone_mum;

    /**
     * @Column(nullable=true)
     * @var string
     */
    public $contact_fathers_name;

    /**
     * @Column(nullable=true)
     * @var string
     */
    public $contact_email_dad;

    /**
     * @Column(nullable=true)
     * @var string
     */
    public $contact_mobile_dad;

    /**
     * @Column(nullable=true)
     * @var string
     */
    public $contact_telephone_dad;

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
            $this->note = Helper::random($faker, 'sentence', 3);
            $this->date_of_birth = $faker->dateTimeBetween('-40 years', '-8 years');
            $this->created_at = $faker->dateTimeBetween($this->date_of_birth);
            $this->sex = $faker->randomElement(self::SEX_ARRAY)['raw_value'];
            $this->status = $faker->randomElement(self::STATUS_ARRAY)['raw_value'];
            $this->ssno = $faker->personalIdentityNumber($this->date_of_birth);
            $this->address_1 = $faker->streetAddress;
            $this->postcode = $faker->postcode;
            $this->town = $faker->city;
            $this->country = 'Sverige';
            $this->email = $faker->safeEmail;
            $this->contact_alt_email = Helper::random($faker, 'safeEmail', 5);
            $this->contact_mobile_phone = Helper::random($faker, 'phoneNumber', 5);
            $this->contact_home_phone = Helper::random($faker, 'phoneNumber', 5);
            $this->contact_mothers_name = Helper::random($faker, 'name', 5);
            $this->contact_mobile_mum = Helper::random($faker, 'phoneNumber', 5);
            $this->contact_telephone_mum = Helper::random($faker, 'phoneNumber', 5);
            $this->contact_email_mum = Helper::random($faker, 'safeEmail', 5);
            $this->contact_fathers_name = Helper::random($faker, 'name', 5);
            $this->contact_mobile_dad = Helper::random($faker, 'phoneNumber', 5);
            $this->contact_telephone_dad = Helper::random($faker, 'phoneNumber', 5);
            $this->contact_email_dad = Helper::random($faker, 'safeEmail', 5);
        }
    }

    private function random($faker, $field, $chance)
    {
        return $faker->randomDigit < $chance ? $faker->{$field} : null;
    }
}
