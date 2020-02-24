<?php

namespace Scouterna\ScoutnetMock\Database;

use Faker\Provider\Base;
use Generator;

class Field
{
    private $optionalWeight;

    private $unique;

    private $validator;

    public function __construct()
    {
        $this->optionalWeight = 1;
        $this->unique = false;
        $this->validator = null;
    }

    public function setWeight(float $weight)
    {
        if ($weight < 0 || $weight > 1) {
            return false;
        }
        $this->optionalWeight = $weight;
        return true;
    }

    public function getWeight()
    {
        return $this->optionalWeight;
    }

    public function setUnique(bool $unique = true)
    {
        $this->unique = $unique;
    }

    public function getUnique()
    {
        return $this->unique;
    }

    public function setValidator(callable $validator)
    {
        $this->validator = $validator;
    }

    public function getValidator()
    {
        return $this->validator;
    }

    public function modify(Base $provider){
        if ($this->unique){
            $provider = $provider->unique();
        }
        $provider = $provider->valid($this->validator);
        $provider = $provider->optional($this->optionalWeight);
        return $provider;
    }
}
