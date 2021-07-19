<?php
namespace Hermes\Facades;

use Closure;
use Hermes\MessageBroker;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void publish(string $bindingKey, string $message, array $options = [])
 * @method static void consume(string $queue, Closure $closure)
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