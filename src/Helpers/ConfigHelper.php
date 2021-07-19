<?php
namespace JohnDev\Hermes\Helpers;

use Illuminate\Support\Facades\Config;

class ConfigHelper
{
    public static function get(string $key)
    {
       return Config::get('hermes.' . $key);
    }
}