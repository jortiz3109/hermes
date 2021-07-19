<?php

namespace JohnDev\Hermes;

use Closure;

final class Consumer extends Context
{
    public function consume(string $queue, Closure $closure): void
    {
        $this->carrier->consume($queue, $closure);
    }
}