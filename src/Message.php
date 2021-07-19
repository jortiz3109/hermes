<?php

namespace JohnDev\Hermes;

use Hermes\Contracts\MessageContract;

abstract class Message implements MessageContract
{

    abstract public function body(): string;

    abstract function attributes(): array;

    abstract public function ack(): void;
}