<?php

namespace JohnDev\Hermes;

use Closure;

class MessageBroker
{
    public function publish(string $bindingKey, string $message, array $options = []): void
    {
        (new Publisher())->publish($bindingKey, $message, $options);
    }

    public function consume(string $queue, Closure $closure): void
    {
        (new Consumer())->consume($queue, $closure);
    }
}