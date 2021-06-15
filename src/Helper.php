<?php

namespace Scouterna\Mocknet;

class Helper
{
    public static function getFaker()
    {
        $faker = \Faker\Factory::create('sv_SE');
        $faker->addProvider(new Organisation($faker));
        return $faker;
    }
}
