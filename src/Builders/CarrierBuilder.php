<?php
namespace Hermes\Builders;

use Hermes\Carriers\AMQPCarrier;
use Hermes\Contracts\CarrierContract;
use Hermes\Helpers\ConfigHelper;

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