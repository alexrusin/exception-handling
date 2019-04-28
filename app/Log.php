<?php 

namespace Apr\ExceptionHandling;

use DateTime;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

abstract class Log
{
    private static $logger;

    private static function getLogger()
    {
        if (self::$logger) {
            return self::$logger;
        }

        $logger = new Logger(Config::get('env'));

        $formatter = new LineFormatter(null, null, false, true);
        $now = (new DateTime("now"))->format('m_d_Y');

        $handler = new StreamHandler(__DIR__ . "/../logs/app_log_$now.log", Logger::INFO);
        $handler->setFormatter($formatter);

        $logger->pushHandler($handler);

        return self::$logger = $logger;
    }

    public static function __callStatic($name, $arguments)
    {
        if (empty($arguments)) {
           throw new \InvalidArgumentException("There is no message to log");
        }

        $message = $arguments[0];

        $logger = self::getLogger();

        $logger->$name($message);
    }
}