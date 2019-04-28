<?php

namespace Apr\ExceptionHandling\Mailer;

use Apr\ExceptionHandling\Log;

class Mail
{
    public $to;
    public $from;
    public $subject = 'Email Notification';
    public $message;

    public static function to($addresses) 
    {
        if (!is_array($addresses)) {
            $to = [$addresses];
        } else {
            $to = $addresses;
        }

        $instance = new self;
        $instance->to = $to;
        return $instance;
    }

    public function from($addresses) 
    {
        if (!is_array($addresses)) {
            $this->from = [$addresses];
        } else {
            $this->from = $addresses;
        }

        return $this;
    }

    public function message($message)
    {
        $this->message = $message;
        return $this;
    }

    public function subject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function send()
    {
        $mailer = new Mailer;

        try {
            $mailer->send($this);
        } catch (\Throwable $e) {
            Log::error($e);
        }

        
    }
}