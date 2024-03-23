<?php

namespace App\Services\OTP;

use App\Contracts\SendSms;

class Sparrow implements SendSms {
    public function send($to, $from, $text, $template_id)
    {
        $url = "http://api.sparrowsms.com/v2/sms/";

        $args = http_build_query(array(
            "token" => env('SPARROW_TOKEN'),
            "from" => env('MESSGAE_FROM'),
            "to" => $to,
            "text" => $text
        ));
        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Response
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}