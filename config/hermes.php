<?php

return [
    'default' => env('HERMES_DEFAULT_BROKER', 'amqp'),
    'connections' => [
        'amqp' => [
            'exchange' => [
                'name' => env('HERMES_AMQP_EXCHANGE_NAME', 'amq.direct'),
                'type' => env('HERMES_AMQP_EXCHANGE_TYPE', 'direct')
            ],
            'queue' => [
                'name' => env('HERMES_AMQP_QUEUE_NAME', 'hermes')
            ],
            'host' => env('HERMES_AMQP_HOST', ''),
            'port' => env('HERMES_AMQP_PORT', '5672'),
            'user' => env('HERMES_AMQP_USER', ''),
            'password' => env('HERMES_AMQP_PASSWORD', ''),
            'vhost' => env('HERMES_AMQP_VHOST', '/'),
            'ssl' => env('HERMES_AMQP_SSL', true),
            'ssl_options' => [
                'ssl_protocol' => env('HERMES_AMQP_SSL_PROTOCOL', 'ssl'),
            ]
        ],
    ],
];
