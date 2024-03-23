<?php

namespace App\Services\OTP;

use App\Contracts\SendSms;

class Nexmo implements SendSms {
    public function send($to, $from, $text, $template_id) {
        $api_key = env("NEXMO_KEY"); //put ssl provided api_token here
        $api_secret = env("NEXMO_SECRET"); // put ssl provided sid here

        $params = [
            "api_key" => $api_key,
            "api_secret" => $api_secret,
            "from" => env("NEXMO_SENDER_ID"),
            "text" => $text,
            "to" => $to
        ];

        $url = "https://rest.nexmo.com/sms/json";
        $params = json_encode($params);

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($params),
            'accept:application/json'
        ));
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}