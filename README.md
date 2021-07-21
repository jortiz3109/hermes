# Hermes

Hermes is a simple wrapper for popular message brokers

## Installation
Require this package with composer.
```shell
composer require johndev/hermes
```

This package use the Laravel Package Auto-Discovery, so is not required you to manually add the ServiceProvider.

### No auto-discovery is available
If you don't use Laravel auto-discovery, add the ServiceProvider to the providers array in config/app.php.
```php
Hermes\Providers\HermesServiceProvider::class,
```

If you want to use the Hermes facade, add this to your facades array in config/app.php.
```php
'Hermes' => Hermes\Facades\Hermes::class,
```

### Configuration file

To publish the configuration file for hermes execute this command into your project.
```shell
php artisan vendor:publish --provider="JohnDev\Hermes\Providers\HermesServiceProvider"
```

## Configuration

### Default broker
To configure the default message broker used by the package, change this in your environment file.

```shell
HERMES_DEFAULT_BROKER="amqp"
```

### AMQP Message broker configuration
| Variable                  | Description                                                   | Default value |
|---------------------------|---------------------------------------------------------------|---------------|
| AMQP_EXCHANGE_NAME | Name of the exchange to use                                   | amq.direct    |
| AMQP_EXCHANGE_TYPE | Type of exchange to be used                                   | direct        |
| AMQP_QUEUE_NAME    | Name to the queue to be connected                             | hermes        |
| AMQP_HOST          | The host to connect                                           |               |
| AMQP_PORT          | Port to be used to connect to amq host                        | 5672          |
| AMQP_USER          | User to be used to authenticate against host                  |               |
| AMQP_PASSWORD      | Password to be used to authenticate against host              |               |
| AMQP_VHOST         | Vhost to be used to connect to amq host                       | '/'           |
| AMQP_SSL_PROTOCOL  | Indicates the ssl protocol to use when connecting to the host | ssl           |

## Usage
### Publish
#### Publish a message

```php
<?php

use Hermes\Facades\Hermes;

$bindingKey = 'co.johndev.test';
$message = 'Test message';

Hermes::publish($bindingKey, $message);
```

### Consume

#### Consume a message and finish

```php
<?php

use JohnDev\Hermes\Message;
use JohnDev\Hermes\Contracts\CarrierContract;

Hermes::consume(function(Message $message, CarrierContract $carrier) {
    dump($message->body());
    $message->ack();
    $carrier->finish();
});
```

#### Consume a message with different queue

```php
<?php

use JohnDev\Hermes\Facades\Hermes;
use JohnDev\Hermes\Message;
use JohnDev\Hermes\Contracts\CarrierContract;

Hermes::queue('queue-name')->consume(function(Message $message, CarrierContract $carrier) {
    dump($message->body());
    $message->ack();
    $carrier->finish();
});
```

### Customize configuration in execution time
If you want to customize the configuration in execution time, use the config() method available in Hermes facade

```php
<?php

use JohnDev\Hermes\Facades\Hermes;
use JohnDev\Hermes\Message;
use JohnDev\Hermes\Contracts\CarrierContract;

$config = [
'consume' => [
        'tag' => 'custom-tag',
        'timeout' => 10,
    ]
];

Hermes::config($config)->consume(function(Message $message, CarrierContract $carrier) {
    dump($message->body());
    $message->ack();
    $carrier->finish();
});
```