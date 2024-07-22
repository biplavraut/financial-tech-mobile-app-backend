<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Http\Requests\StoreOtpRequest;
use App\Http\Requests\UpdateOtpRequest;
use App\Http\Resources\Api\UserResource;
use App\Services\OtpService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;

class OtpController extends Controller
{
    public function __construct(protected OtpService $otpService, protected UserService $userService)
    {
        $this->otpService = $otpService;
        $this->userService = $userService;
    }

    public function sendOtp(Request $request)
    {
        $user = $this->userService->query()->where('phone', $request->phone)->where('country_code', $request->countryCode)->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Phone Not Registered.', 'statusCode' => 412]);
        }
        $sendOtp = $this->otpService->sendOtp($request);
        //dd($sendOtp['response']['response_code']);
        if ($sendOtp['response']['response_code'] == 400) {
            $request->merge(['user_id' => $user->id, 'remarks' => "User Register. OTP Sent"]);
            return response()->json(['status' => true, 'message' => 'Otp sent successfully.', 'statusCode' => 200], 200);
        } else {
            $sendOtp['otp']->delete();
            return response()->json(['status' => false, 'message' => $sendOtp['response']['response'], 'statusCode' => $sendOtp['response']['response_code']], 422);
        }
    }

    public function verifyOtp(Request $request)
    {
        $user = $this->userService->query()->where('phone', $request->phone)->first();
        // return $user;
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Phone Not Registered.', 'statusCode' => 412]);
        }
        if ($this->otpService->verifyMyOtp($request->otp, '+' . $request->countryCode . $request->phone)) {
            //return successResponse("Otp matched successfully.");
            // Revoke all tokens...
            $user->tokens()->delete();

            Auth::login($user);
            $user = Auth::user();
            if(!$user->isPhoneVerified()){
                $user->verifyPhone();
            }

            $success =  $user->createToken('bibaabo')->plainTextToken;
            
            return (new UserResource($user))->additional([
                'token' => $success,
                'status' => true,
                'message' => "OTP Matched.",
                'statusCode' => 200
            ], Response::HTTP_OK);
        }
        return failureResponse("otp doesnot match", 404, 404);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOtpRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Otp $otp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Otp $otp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOtpRequest $request, Otp $otp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Otp $otp)
    {
        //
    }
}
