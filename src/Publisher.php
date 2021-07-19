<?php

namespace JohnDev\Hermes;

final class Publisher extends Context
{
    public function publish(string $routingKey, string $message, array $options = []): void
    {
        $this->carrier->publish($routingKey, $message, $options);
    }
}