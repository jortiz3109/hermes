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

## Usage