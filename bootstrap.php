<?php

require __DIR__ . '/vendor/autoload.php';

use Apr\ExceptionHandling\Config;
use Apr\ExceptionHandling\Exceptions\ExceptionHandler;

$whoops = new \Whoops\Run;

if (Config::get('env') === 'develop') {
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
}

$whoops->pushHandler(function ($exception, $inspector, $run) {
    $exceptionHandler = new ExceptionHandler;
    $exceptionHandler->report($exception);
});

$whoops->register();