<?php

namespace JohnDev\Hermes;

use JohnDev\Hermes\Builders\CarrierBuilder;
use JohnDev\Hermes\Contracts\CarrierContract;

abstract class Context
{
    protected CarrierContract $carrier;
    protected array $config;

    public function __construct(string $carrier, array $config)
    {
        $this->carrier = CarrierBuilder::build($carrier, $config);
    }
}