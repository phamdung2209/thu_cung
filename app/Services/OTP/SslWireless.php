<?php

namespace App\Services\OTP;

use App\Contracts\SendSms;

class SslWireless implements SendSms {
    public function send($to, $from, $text, $template_id)
    {
        $token = env("SSL_SMS_API_TOKEN"); //put ssl provided api_token here
        $sid = env("SSL_SMS_SID"); // put ssl provided sid here

        $params = [
            "api_token" => $token,
            "sid" => $sid,
            "msisdn" => $to,
            "sms" => $text,
            "csms_id" => date('dmYhhmi') . rand(10000, 99999)
        ];

        $url = env("SSL_SMS_URL");
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