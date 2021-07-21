<?php

namespace JohnDev\Hermes;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class MessageBroker
{
    private string $queue;
    private array $config;
    private string $carrier;

    public function __construct()
    {
        $this->carrier = Config::get('hermes.default');
        $this->config = Config::get('hermes.connections.' . $this->carrier);
    }

    public function queue(string $queue): self
    {
        $this->queue = $queue;

        return $this;
    }

    public function config(array $config): self
    {
        $this->config = array_replace_recursive($this->config, $config);

        return $this;
    }

    public function publish(string $bindingKey, string $message, array $options = []): void
    {
        (new Publisher($this->carrier, $this->config))->publish($bindingKey, $message, $options);
    }

    public function consume(Closure $closure): void
    {
        $queue = $this->queue ?? Arr::get($this->config, 'queue.name');

        (new Consumer($this->carrier, $this->config))->consume($queue, $closure);
    }
}