<?php

require __DIR__ . '/../bootstrap.php';

use Apr\ExceptionHandling\Log;

Log::info('test log');

Log::info();

echo 'Hello';