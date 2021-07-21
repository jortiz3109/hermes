<?php
namespace JohnDev\Hermes\Carriers;

use Closure;
use Illuminate\Support\Arr;
use JohnDev\Hermes\Messages\AMQPMessage as Message;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPSSLConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class AMQPCarrier extends CarrierBase
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;
    private array $exchange;
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->setConnection();
        $this->channel = $this->connection->channel();
        $this->exchange = Arr::get($config, 'exchange.name');
    }

    public function publish(string $routingKey, string $message, array $options = []): void
    {
        $this->channel->basic_publish($this->message($message, Arr::get($options, 'properties', [])), $this->exchange['name'], $routingKey);
    }

    public function consume($queue, Closure $closure): void
    {
        $this->channel->basic_consume(
            $queue,
            Arr::get($this->config, 'consume.tag', ''),
            Arr::get($this->config, 'consume.no_local', false),
            Arr::get($this->config, 'consume.no_ack', false),
            Arr::get($this->config, 'consume.exclusive', false),
            Arr::get($this->config, 'consume.no_wait', false),
            function (AMQPMessage $message) use ($closure) {
                $closure(new Message($message), $this);
            },
        );

        while ($this->channel->callbacks && false === $this->finish) {
            $this->channel->wait(null, false, Arr::get($this->config, 'consume.timeout', 2),);
        }

        $this->channel->close();
        $this->connection->close();
    }

    private function setConnection(): void
    {
        $this->connection = new AMQPSSLConnection(
            Arr::get($this->config, 'host'),
            Arr::get($this->config, 'port'),
            Arr::get($this->config, 'user'),
            Arr::get($this->config, 'password'),
            Arr::get($this->config, 'vhost'),
            Arr::get($this->config, 'ssl_options')
        );

        $this->connection->set_close_on_destruct(true);
    }

    private function message(string $message, array $properties): AMQPMessage
    {
        return new AMQPMessage($message, $properties);
    }
}
