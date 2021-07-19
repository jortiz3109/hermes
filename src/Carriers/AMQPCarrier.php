<?php
namespace JohnDev\Hermes\Carriers;

use Closure;
use JohnDev\Hermes\Helpers\ConfigHelper;
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

    public function __construct()
    {
        $this->setConnection();
        $this->channel = $this->connection->channel();
            $this->exchange = ConfigHelper::get('connections.amqp.exchange');
    }

    public function publish(string $routingKey, string $message, array $options = []): void
    {
        $this->channel->basic_publish($this->message($message, Arr::get($options, 'properties', [])), $this->exchange['name'], $routingKey);
    }

    public function consume($queue, Closure $closure): void
    {
        $this->channel->basic_consume(
            $queue,
            '',
            false,
            false,
            false,
            false,
            function (AMQPMessage $message) use ($closure) {
                $closure(new Message($message), $this);
            },
        );

        while ($this->channel->callbacks && false === $this->finish) {
            $this->channel->wait(null, false, 2);
        }

        $this->channel->close();
        $this->connection->close();
    }

    private function setConnection(): void
    {
        $connectionConfig = ConfigHelper::get('connections.amqp');
        $this->connection = new AMQPSSLConnection(
            $connectionConfig['host'],
            $connectionConfig['port'],
            $connectionConfig['user'],
            $connectionConfig['password'],
            $connectionConfig['vhost'],
            $connectionConfig['ssl_options']
        );

        $this->connection->set_close_on_destruct(true);
    }

    private function message(string $message, array $properties): AMQPMessage
    {
        return new AMQPMessage($message, $properties);
    }
}
