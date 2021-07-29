<?php
namespace JohnDev\Hermes\Carriers;

use Closure;
use ErrorException;
use Exception;
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
        $this->exchange = Arr::get($config, 'exchange');
    }

    public function publish(string $routingKey, string $message, array $options = []): void
    {
        $this->channel->basic_publish($this->message($message, Arr::get($options, 'properties', [])), $this->exchange['name'], $routingKey);
    }

    /**
     * @throws ErrorException
     * @throws Exception
     */
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
            $this->channel->wait(null, false, Arr::get($this->config, 'consume.timeout', 2));
        }

        $this->channel->close();
        $this->connection->close();
    }

    private function setConnection(): void
    {
        Arr::get($this->config, 'ssl', true)
            ? $this->setSSLConnection()
            : $this->setStreamConnection();

        $this->connection->set_close_on_destruct(true);
    }

    private function message(string $message, array $properties): AMQPMessage
    {
        return new AMQPMessage($message, $properties);
    }

    private function setStreamConnection()
    {
        $this->connection = new AMQPStreamConnection(
            Arr::get($this->config, 'host'),
            Arr::get($this->config, 'port'),
            Arr::get($this->config, 'user'),
            Arr::get($this->config, 'password'),
            Arr::get($this->config, 'vhost'),
            Arr::get($this->config, 'options.insist'),
            Arr::get($this->config, 'options.login_method'),
            Arr::get($this->config, 'options.login_response'),
            Arr::get($this->config, 'options.locale'),
            Arr::get($this->config, 'options.connection_timeout'),
            Arr::get($this->config, 'options.read_write_timeout'),
            null,
            Arr::get($this->config, 'options.keepalive'),
            Arr::get($this->config, 'options.heartbeat'),
            Arr::get($this->config, 'options.channel_rpc_timeout'),
        );
    }

    private function setSSLConnection()
    {
        $sslOptions = array_filter(Arr::get($this->config, 'ssl_options', []), function($item) {
            return null !== $item;
        });

        $this->connection = new AMQPSSLConnection(
            Arr::get($this->config, 'host'),
            Arr::get($this->config, 'port'),
            Arr::get($this->config, 'user'),
            Arr::get($this->config, 'password'),
            Arr::get($this->config, 'vhost'),
            $sslOptions,
            Arr::get($this->config, 'options', []),
        );
    }
}
