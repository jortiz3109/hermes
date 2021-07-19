<?php

namespace JohnDev\Hermes;

use JohnDev\Hermes\Builders\CarrierBuilder;
use JohnDev\Hermes\Contracts\CarrierContract;

abstract class Context
{
    protected CarrierContract $carrier;

    public function __construct()
    {
        $this->carrier = CarrierBuilder::build();
    }
}