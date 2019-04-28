<?php

namespace Apr\ExceptionHandling\Mailer;

use Apr\ExceptionHandling\Config;
use Apr\ExceptionHandling\Log;

class Mailer
{
    public function send($mail)
    {
        if (Config::get('mail_driver') === 'smtp') {

            $transport = (new \Swift_SmtpTransport(Config::get('mail_host'), (int) Config::get('mail_port')))
            ->setUsername(Config::get('mail_username'))
            ->setPassword(Config::get('mail_password'))
            ;

            // Create the Mailer using your created Transport
            $mailer = new \Swift_Mailer($transport);

            // Create a message
            $message = (new \Swift_Message($mail->subject))
            ->setFrom($mail->from)
            ->setTo($mail->to)
            ->setBody($mail->message)
            ;

            return $mailer->send($message);

        }

        Log::info(json_encode($mail));
    }
}