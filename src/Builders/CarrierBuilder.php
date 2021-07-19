<?php
namespace JohnDev\Hermes\Builders;

use JohnDev\Hermes\Carriers\AMQPCarrier;
use JohnDev\Hermes\Contracts\CarrierContract;
use JohnDev\Hermes\Helpers\ConfigHelper;

class CarrierBuilder
{
    private const CARRIERS = [
        'amqp' => AMQPCarrier::class
    ];

    public static function build(): CarrierContract
    {
        $brokerClass = self::resolver();
        return new $brokerClass();
    }

    private static function resolver(): string
    {
        return self::CARRIERS[ConfigHelper::get('default')];
    }
}