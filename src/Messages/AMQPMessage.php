<?php
namespace JohnDev\Hermes\Messages;

use JohnDev\Hermes\Message;
use PhpAmqpLib\Message\AMQPMessage as AMQPMessageBase;

class AMQPMessage extends Message
{
    private AMQPMessageBase $message;

    public function __construct(AMQPMessageBase $message)
    {
        $this->message = $message;
    }

    public function body(): string
    {
        return $this->message->getBody();
    }

    function attributes(): array
    {
        return $this->message->get_properties();
    }

    public function ack(): void
    {
        $this->message->ack();
    }
}