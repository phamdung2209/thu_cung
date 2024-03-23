<?php

namespace App\Services\OTP;

use App\Contracts\SendSms;

class Msegat implements SendSms {
    public function send($to, $from, $text, $template_id)
    {
        $url = "https://www.msegat.com/gw/sendsms.php";
        $data = [
            "apiKey" => env('MSEGAT_API_KEY'),
            "numbers" => $to,
            "userName" => env('MSEGAT_USERNAME'),
            "userSender" => env('MSEGAT_USER_SENDER'),
            "msg" => $text
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}