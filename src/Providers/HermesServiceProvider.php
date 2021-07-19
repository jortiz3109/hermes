<?php
namespace JohnDev\Hermes\Providers;

use Illuminate\Support\ServiceProvider;

class HermesServiceProvider extends ServiceProvider
{
    protected bool $defer = true;

    public function boot(): void
    {
        $this->publishConfig();
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/hermes.php', 'hermes');
    }

    private function publishConfig(): void
    {
        $this->publishes([__DIR__ . '/../../config/hermes.php' => config_path('hermes.php')]);
    }
}