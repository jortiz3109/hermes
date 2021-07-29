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
            'port' => env('AMQP_PORT', 5672),
            'user' => env('AMQP_USER', ''),
            'password' => env('AMQP_PASSWORD', ''),
            'vhost' => env('AMQP_VHOST', '/'),
            'ssl' => env('AMQP_SSL', true),
            'options' => [
                'insist' => env('AMQP_OPTIONS_INSIST'),
                'login_method' => env('AMQP_OPTIONS_LOGIN_METHOD'),
                'login_response' => env('AMQP_OPTIONS_LOGIN_RESPONSE'),
                'locale' => env('AMQP_OPTIONS_LOCALE'),
                'connection_timeout' => env('AMQP_OPTIONS_CONNECTION_TIMEOUT'),
                'read_write_timeout' => env('AMQP_OPTIONS_READ_WRITE_TIMEOUT'),
                'keepalive' => env('AMQP_OPTIONS_KEEPALIVE'),
                'heartbeat' => env('AMQP_OPTIONS_HEARTBEAT'),
                'channel_rpc_timeout' => env('AMQP_OPTIONS_CHANNEL_RPC_TIMEOUT'),
            ],
            'ssl_options' => [
                'cafile' => env('AMQP_OPTIONS_SSL_CAFILE'),
                'local_cert' => env('AMQP_OPTIONS_SSL_LOCALCERT'),
                'local_key' => env('AMQP_OPTIONS_SSL_LOCALKEY'),
                'verify_peer' => env('AMQP_OPTIONS_SSL_VERIFY_PEER', true),
                'passphrase' => env('AMQP_OPTIONS_SSL_PASSPHRASE'),
            ],
            'ssl_enabled' => env('AMQP_SSL_ENABLED', true),
            'ssl_protocol' => env('AMQP_SSL_PROTOCOL', 'ssl'),
        ],
    ],
];
