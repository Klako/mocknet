<?php

namespace Scouterna\Mocknet\Database;

use Faker\Generator;
use Faker\Provider\Base;
use Faker\Provider\Person;

class Member extends TableConfig
{
    public function __construct(Generator $faker)
    {
        parent::__construct($faker, 100);
    }

    public static function getRowCols()
    {
        return [
            'first_name',
            'last_name',
            'ssno',
            'note',
            'date_of_birth',
            'status',
            'created_at',
            'sex',
            'address_1',
            'postcode',
            'town',
            'country',
            'email',
            'contact_alt_email',
            'contact_mobile_phone',
            'contact_home_phone',
            'contact_mothers_name',
            'contact_email_mum',
            'contact_mobile_mum',
            'contact_telephone_mum',
            'contact_fathers_name',
            'contact_email_dad',
            'contact_mobile_dad',
            'contact_telephone_dad',
            'contact_leader_interest',
        ];
    }

    public function getRowValues()
    {
        $sex = $this->faker->boolean;
        $dob = $this->faker->dateTimeBetween('-50 years', '-10 years');
        $created = $this->faker->dateTimeBetween($dob, 'now');
        $values = [
            'first_name' => $this->faker->firstName($sex),
            'last_name' => $this->faker->lastName,
            'ssno' => $dob->format('Ymd-1234'),
            'note' => $this->faker->optional()->text,
            'date_of_birth' => $dob->format('Y-m-d'),
            'status' => 2,
            'create_at' => $created->format('Y-m-d'),
            'sex' => $sex ? '1' : '2',
            'address_1' => $this->faker->streetAddress,
            'postcode' => $this->faker->regexify('\d{6}'),
            'town' => $this->faker->city,
            'country' => 'Sweden',
            'email' => $this->faker->email,
            'contact_alt_email' => $this->faker->optional()->email,
            'contact_mobile_phone' => $this->faker->optional()->phoneNumber,
            'contact_home_phone' => $this->faker->optional()->phoneNumber,
            'contact_leader_interest' => $this->faker->boolean ? 'Ja' : 'Nej',
        ];
        if ($this->faker->boolean) {
            $values['contact_mothers_name'] = $this->faker->name;
            $values['contact_email_mum'] = $this->faker->email;
            $values['contact_mobile_mum'] = $this->faker->phoneNumber;
            $values['contact_telephone_mum'] = $this->faker->phoneNumber;
            if ($this->faker->boolean) {
                $values['contact_fathers_name'] = $this->faker->name;
                $values['contact_email_dad'] = $this->faker->email;
                $values['contact_mobile_dad'] = $this->faker->phoneNumber;
                $values['contact_telephone_dad'] = $this->faker->phoneNumber;
            }
        }
        return $values;
    }

    public static function getTableSql()
    {
        return <<<SQL
        CREATE TABLE "members" (
	        "member_no"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	        "first_name"	TEXT NOT NULL,
	        "last_name"	TEXT NOT NULL,
	        "ssno"	TEXT NOT NULL,
	        "note"	TEXT,
	        "date_of_birth"	TEXT NOT NULL,
	        "status"	INTEGER NOT NULL,
	        "created_at"	TEXT NOT NULL,
	        "sex"	INTEGER NOT NULL,
	        "address_1"	TEXT NOT NULL,
	        "postcode"	TEXT NOT NULL,
	        "town"	TEXT NOT NULL,
	        "country"	TEXT NOT NULL,
	        "email"	TEXT,
	        "contact_alt_email"	TEXT,
	        "contact_mobile_phone"	TEXT,
	        "contact_home_phone"	TEXT,
	        "contact_mothers_name"	TEXT,
	        "contact_email_mum"	TEXT,
	        "contact_mobile_mum"	TEXT,
	        "contact_telephone_mum"	TEXT,
	        "contact_fathers_name"	TEXT,
	        "contact_email_dad"	TEXT,
	        "contact_mobile_dad"	TEXT,
	        "contact_telephone_dad"	TEXT,
	        "contact_leader_interest"	TEXT
        );
        SQL;
    }
}
