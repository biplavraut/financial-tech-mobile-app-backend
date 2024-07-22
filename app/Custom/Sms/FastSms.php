<?php

namespace App\Custom\Sms;

use Illuminate\Support\Facades\Http;

class FastSms
{
    public $mobile_number;
    public $message;
    public $is_otp;

    public function __construct(string $mobile_number = null, string $message, $is_otp)
    {
        $this->mobile_number = $mobile_number;
        $this->message = $message;
        $this->is_otp = $is_otp;
    }

    public function sendMessage()
    {
        $apiURL = 'https://app.fastsms.com.np/api/v1/sms/send';

        $postInput = [
            'mobile_number' => $this->mobile_number,
            'message' => $this->message,
            'is_otp' => $this->is_otp
        ];



        $headers = [

            'apikey' => env('API_TOKEN', '7d49ynbms5oocs0oo8kgo8oko0488o0')

        ];



        $response = Http::withHeaders($headers)->post($apiURL, $postInput);



        $statusCode = $response->status();

        $responseBody = json_decode($response->getBody(), true);

        return $responseBody;
    }
}
