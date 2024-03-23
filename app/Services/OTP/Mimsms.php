<?php

namespace App\Services\OTP;

use App\Contracts\SendSms;

class Mimsms implements SendSms{
    public function send($to, $from, $text, $template_id)
    {
        $url = "https://api.mimsms.com/api/SmsSending/SMS";

        if ($to[0] == '+'){
            $to = substr($to, 1);
        }

        $data = [
            "UserName"=> env('MIM_USER_NAME'),
            "Apikey"=> env('MIM_API_KEY'),
            "MobileNumber"=> $to,
            "CampaignId"=>"null",
            "SenderName"=> env('MIM_SENDER_ID'),
            "TransactionType"=> "T",
            "Message"=> $text
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'accept:application/json'
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}