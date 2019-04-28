<?php

namespace Apr\ExceptionHandling\Exceptions;

use Apr\ExceptionHandling\Log;
use Apr\ExceptionHandling\Config;
use Apr\ExceptionHandling\Mailer\Mail;

class ExceptionHandler 
{
    public function report($exception) 
    {
        Log::error($exception);

        if (Config::get('env') === 'production') 
        {
            Mail::to(Config::get('mail_to_admin'))
                ->from(Config::get('mail_from_address'))
                ->subject('Exception occured')
                ->message($exception)
                ->send();
            
            throw $exception;
            // or display 500 error page
        }
    }
}