<?php

namespace Scouterna\Mocknet\Util;

class Helper
{
    public static function getFaker()
    {
        $faker = \Faker\Factory::create('sv_SE');
        $faker->addProvider(new Organisation($faker));
        return $faker;
    }

    public static function keyify($value)
    {
        return \mb_strtolower(\str_replace(' ', '_', $value));
    }

    public static function random($faker, $field, $chance)
    {
        return $faker->randomDigit < $chance ? $faker->{$field} : null;
    }
}
