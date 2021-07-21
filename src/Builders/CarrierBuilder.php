<?php
namespace JohnDev\Hermes\Builders;

use JohnDev\Hermes\Carriers\AMQPCarrier;
use JohnDev\Hermes\Contracts\CarrierContract;

class CarrierBuilder
{
    private const CARRIERS = [
        'amqp' => AMQPCarrier::class
    ];

    public static function build(string $carrier, array $config): CarrierContract
    {
        $carrierClass = self::CARRIERS[$carrier];
        return new $carrierClass($config);
    }
}