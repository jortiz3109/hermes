<?php

namespace JohnDev\Hermes\Carriers;

use Closure;
use JohnDev\Hermes\Contracts\CarrierContract;

abstract class CarrierBase implements CarrierContract
{
    protected bool $finish = false;
    abstract public function publish(string $routingKey, string $message, array $options = []);
    abstract public function consume($queue, Closure $closure): void;

    public function finish(): void
    {
        $this->finish = true;
    }
}