<?php

namespace JohnDev\Hermes\Contracts;

use Closure;

interface CarrierContract
{
    public function publish(string $routingKey, string $message, array $options = []);
    public function consume($queue, Closure $closure): void;
}