<?php

namespace App\Services\OTP;

use App\Contracts\SendSms;
use Twilio\Rest\Client;

class Twillo implements SendSms
{

    public function send($to, $from, $text, $template_id)
    {
        $sid = env("TWILIO_SID"); // Your Account SID from www.twilio.com/console
        $token = env("TWILIO_AUTH_TOKEN"); // Your Auth Token from www.twilio.com/console
        $type = env("TWILLO_TYPE"); // sms type

        $client = new Client($sid, $token);
        try {
            $client->messages->create(
                ($type == 1) ? $to : "whatsapp:" . $to, // Text this number
                array(
                    'from' =>  ($type == 1) ? env('VALID_TWILLO_NUMBER') : "whatsapp:" . env('VALID_TWILLO_NUMBER'), // From a valid Twilio number
                    'body' => $text
                )
            );
        } catch (\Exception $e) {
        }
    }
}
