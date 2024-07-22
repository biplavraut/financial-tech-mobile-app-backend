<?php

namespace App\Services;

use App\Custom\Sms\FastSms;
use App\Custom\Sms\TeleSandesh;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;

class OtpService extends ModelService
{
    const MODEL = Otp::class;

    public function sendOtp(Request $request)
    {
        //dd($request);

        $oldOtp = Otp::where('phone', '+' . $request->countryCode . $request->phone)->first();


        if ($oldOtp) {
            $oldOtp->delete();
        }

        $otp = randomNumericString(4);

        while (!$this->generateOtp($otp)) {
            $otp = randomNumericString(4);
        }

        // try {
            $userOtp =  Otp::create(['otp' => $otp, 'phone' => '+'.$request->countryCode.$request->phone]);
            
            $message = "Dear User,\n";
            $message .= 'Welcome to ' . env('APP_NAME', 'Bibaabo') . '.';
            $message .= ' Your OTP is ' . $otp . '.';
            $message .= ' It is valid for 15 minutes.';
            $message .= ' Thank You! ';
            $message .= ' Best Regards - Team ' . env('APP_NAME', 'Bibaabo') . ' ' . $request->appId ?? '';
            //dd($userOtp->phone);
            $sms = new TeleSandesh($request->phone, $message);
            $response = $sms->sendMessage();
            return ['response' => $response];
        // } catch (\Throwable $th) {
        //     return response()->json(['status' => false, 'message' => 'error', 'statusCode' => 422], 422);
        // }
    }

    public function generateOtp($otp)
    {
        $isExist = Otp::where('otp', $otp)->first();

        if ($isExist) {
            return false;
        }
        return true;
    }


    public function verifyMyOtp($otp, $phone)
    {
        $isExist = Otp::where('otp', $otp)->Where('phone', $phone)->first();
        if ($isExist) {
            return true;
        }
        return false;
    }
}
