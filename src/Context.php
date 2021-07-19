<?php

namespace JohnDev\Hermes;

use Hermes\Builders\CarrierBuilder;
use Hermes\Contracts\CarrierContract;

abstract class Context
{
    protected CarrierContract $carrier;

    public function __construct()
    {
        $this->carrier = CarrierBuilder::build();
    }
}