<?php

namespace App\Services\OTP;

use App\Contracts\SendSms;

class Fast2sms implements SendSms {
    
    public function send($to, $from, $text, $template_id)
    {
        if (strpos($to, '+91') !== false) {
            $to = substr($to, 3);
        }

        if (env("ROUTE") == 'dlt_manual') {
            $fields = array(
                "sender_id" => env("SENDER_ID"),
                "message" => $text,
                "template_id" => $template_id,
                "entity_id" => env("ENTITY_ID"),
                "language" => env("LANGUAGE"),
                "route" => env("ROUTE"),
                "numbers" => $to,
            );
        } else {
            $fields = array(
                "sender_id" => env("SENDER_ID"),
                "message" => $text,
                "language" => env("LANGUAGE"),
                "route" => env("ROUTE"),
                "numbers" => $to,
            );
        }


        $auth_key = env('AUTH_KEY');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($fields),
            CURLOPT_HTTPHEADER => array(
                "authorization: $auth_key",
                "accept: */*",
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return $response;
    }
}