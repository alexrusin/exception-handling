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

        } else if (Config::get('mail_driver') === 'mandrill') {
            
            $mandrill = new \Mandrill(Config::get('mandrill_key'));

            $to = [];
            foreach ($mail->to as $address) {
               $to[] = ['email' => $address]; 
            }

            $message = [
                'html' => "<p>$mail->message</p>",
                'text' => $mail->message,
                'subject' => $mail->subject,
                'from_email' => $mail->from[0],
                'to' => $to,
            ];

            $async = false;
            $ip_pool = 'Main Pool';
            $send_at = (new \DateTime("now"))->format('Y-m-d H:m:s');
            return $mandrill->messages->send($message, $async, $ip_pool, $send_at);            
        }

        Log::info(json_encode($mail));
    }
}