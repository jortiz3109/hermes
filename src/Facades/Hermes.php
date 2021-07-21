<?php
namespace JohnDev\Hermes\Facades;

use Closure;
use JohnDev\Hermes\MessageBroker;
use Illuminate\Support\Facades\Facade;

/**
 * @method static MessageBroker queue(string $queue)
 * @method static void publish(string $bindingKey, string $message, array $options = [])
 * @method static void consume(Closure $closure)
 *
 * @see MessageBroker
 */
class Hermes extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MessageBroker::class;
    }
}