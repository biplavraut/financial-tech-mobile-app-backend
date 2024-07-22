<?php

namespace App\Custom\Sms;
use Illuminate\Support\Facades\Http;

class TeleSandesh
{
    public $mobile_number;
    public $message;

    public function __construct(string $mobile_number = null, string $message)
    {
        $this->mobile_number = $mobile_number;
        $this->message = $message;
    }

    public function sendMessage()
    {
        $apiURL = 'http://telesandesh.com/bulksmsapi/trigger.php';
        $response = Http::get($apiURL, [
            'username' => 'eydean',
            'password' => 'Manish@321#@!',
            'mobile_number' => $this->mobile_number,
            'message' => $this->message,
            'cli' => 'eydean'
        ]);

        $data = $response->json(); // Assuming the response is in JSON format

        return $data;
    }
}
