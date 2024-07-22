<?php

namespace App\Custom\Sms;

class Sparrow
{
    public $phone;
    public $message;
    public $token;

    public function __construct(string $phone, string $message)
    {
        $this->phone = $phone;
        $this->message = $message;
    }

    public function sendMessage()
    {
        $args = http_build_query(array(
            'token' => env('SMS_TOKEN', 'v2_TdzH3HGDl1780dzDymYhHZ9asYw.Pgvn'),
            'from' => env('SMS_NAME', 'sunbi'),
            'to' => $this->phone,
            'text' => $this->message
        ));

        $url = "http://api.sparrowsms.com/v2/sms/";

        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Response
        $response = curl_exec($ch);

        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $status_code;
    }
}
