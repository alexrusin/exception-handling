<?php 

namespace Apr\ExceptionHandling;

abstract class Config
{
    private static $config;

    private static function getConfig() {

        if (self::$config) {
            return self::$config;
        }
        
        return self::$config = require __DIR__ . '/../config/config.php';
      
    }

    public static function get($property) 
    {
        if (!array_key_exists($property, self::getConfig())) {
            return;
        }

        return self::getConfig()[$property];
    }
}