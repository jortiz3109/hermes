<?php

namespace JohnDev\Hermes;

use Closure;
use JohnDev\Hermes\Helpers\ConfigHelper;

class MessageBroker
{
    private string $queue;

    public function publish(string $bindingKey, string $message, array $options = []): void
    {
        (new Publisher())->publish($bindingKey, $message, $options);
    }

    public function consume(Closure $closure): void
    {
        $queue = $this->queue ?? ConfigHelper::get('amqp.queue.name');

        (new Consumer())->consume($queue, $closure);
    }

    public function queue(string $queue): self
    {
        $this->queue = $queue;

        return $this;
    }
}