<?php

namespace Spryng\SpryngRestApi\Objects;

use Spryng\SpryngRestApi\ApiResource;

class Balance extends ApiResource
{
    protected $amount;

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
}