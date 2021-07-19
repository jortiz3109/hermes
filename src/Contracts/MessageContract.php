<?php

namespace JohnDev\Hermes\Contracts;

interface MessageContract
{
    public function body(): string;
    public function attributes(): array;
    public function ack(): void;
}