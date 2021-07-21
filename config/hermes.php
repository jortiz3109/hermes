<?php

return [
    'default' => env('HERMES_DEFAULT_BROKER', 'amqp'),
    'connections' => [
        'amqp' => [
            'exchange' => [
                'name' => env('AMQP_EXCHANGE_NAME', 'amq.direct'),
                'type' => env('AMQP_EXCHANGE_TYPE', 'direct')
            ],
            'queue' => [
                'name' => env('AMQP_QUEUE_NAME', 'hermes')
            ],
            'consume' => [
                'tag' => env('AMQP_CONSUME_TAG', ''),
                'timeout' => 2,
            ],
            'host' => env('AMQP_HOST', ''),
            'port' => env('AMQP_PORT', '5672'),
            'user' => env('AMQP_USER', ''),
            'password' => env('AMQP_PASSWORD', ''),
            'vhost' => env('AMQP_VHOST', '/'),
            'ssl' => env('AMQP_SSL', true),
            'ssl_options' => [
                'ssl_protocol' => env('AMQP_SSL_PROTOCOL', 'ssl'),
            ]
        ],
    ],
];
