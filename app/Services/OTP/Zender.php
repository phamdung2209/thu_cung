<?php

namespace App\Services\OTP;

use App\Contracts\SendSms;

class Zender implements SendSms {
    public function send($to, $from, $text, $template_id)
    {
        if (empty(env('ZENDER_SERVICE')) || env('ZENDER_SERVICE') < 2) {
            if (!empty(env('ZENDER_DEVICE'))) {
                $mode = "devices";
            } else {
                $mode = "credits";
            }

            if ($mode == "devices") {
                $params = [
                    "secret" => env('ZENDER_APIKEY'),
                    "mode" => "devices",
                    "device" => env('ZENDER_DEVICE'),
                    "phone" => $to,
                    "message" => $text,
                    "sim" => env('ZENDER_SIM') < 2 ? 1 : 2
                ];
            } else {
                $params = [
                    "secret" => env('ZENDER_APIKEY'),
                    "mode" => "credits",
                    "gateway" => env('ZENDER_GATEWAY'),
                    "phone" => $to,
                    "message" => $text
                ];
            }

            $apiurl = env('ZENDER_SITEURL') . "/api/send/sms";
        } else {
            $params = [
                "secret" => env('ZENDER_APIKEY'),
                "account" => env('ZENDER_WHATSAPP'),
                "type" => "text",
                "recipient" => $to,
                "message" => $text
            ];

            $apiurl = env('ZENDER_SITEURL') . "/api/send/whatsapp";
        }

        $args = http_build_query($params);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiurl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Response
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}