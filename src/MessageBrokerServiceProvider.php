<?php

use Illuminate\Support\ServiceProvider;

class MessageBrokerServiceProvider extends ServiceProvider
{
    protected bool $defer = true;

    public function boot(): void
    {
        $this->publishes([__DIR__ . '/../config/message-broker.php' => config_path('message-broker.php')]);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/message-broker.php', 'message-broker');
    }
}