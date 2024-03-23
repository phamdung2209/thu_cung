<?php

namespace App\Contracts;

interface SendSms {
    /**
     * Apply four given value to send SMS.
     * @param mixed $value
     */

     public function send($to, $from, $text, $template_id);
}