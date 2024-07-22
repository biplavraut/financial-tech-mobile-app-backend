<?php

namespace App\Http\Controllers\Api;

use App\Custom\Helper\EmailValidator;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\Api\UserResource;
use App\Services\OtpService;
use App\Services\UserLogService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;
use Auth;
use Validator;

class AuthController extends Controller
{
    public function __construct(protected UserService $userService, protected OtpService $otpService, protected UserLogService $userLogService)
    {
        $this->userService = $userService;
        $this->otpService = $otpService;
        $this->userLogService = $userLogService;
    }
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'countryCode'     => 'bail|required|string|min:2',
            'phone'     => 'bail|required|string|min:10|max:10|unique:users,phone',
            'password'     => 'bail|required|string|min:8',
            'deviceName' => 'nullable|string',
            'deviceToken' => 'nullable|string',
            'deviceType' => 'nullable|in:android,ios',
            'lat' => 'nullable',
            'long' => 'nullable',
        ]);

        if ($validator->fails()) {

            return Response(['message' => "The given data is Invalid."], 418);
        }
        try{
            // if ($request->email) {
            //     $response = new EmailValidator($request->email);
            //     if (!$response->validate()) {
            //         return failureResponse("Invalid email.", 422, 422);
            //     }
            // }

            $user = $this->userService->register($request);
            $user->createToken('bibaabo')->plainTextToken;
            if ($user) {
                $sendOtp = $this->otpService->sendOtp($request);
                $request->merge(['userId' => $user->id]);
                $userLog = $this->userLogService->storeUserLog($request, "User Register. OTP Sent");
            }

            return (new UserResource($user))->additional([
                'status' => true,
                //'otp' => $sendOtp['otp']['otp'],
                'message' => "Registration Success. Verify OTP",
                'statusCode' => 200
            ], Response::HTTP_OK);
            return response()->json(['status' => true, 'message' => 'Otp sent successfully.', 'statusCode' => 200], 200);


            // if ($sendOtp['response']['code'] == 200) {                
            //     return (new UserResource($user))->additional([
            //         'status' => true,
            //         'message' => "Registration Success. Verify OTP",
            //         'statusCode' => 200
            //     ], Response::HTTP_OK);
            //     return response()->json(['status' => true, 'message' => 'Otp sent successfully.', 'statusCode' => 200], 200);
            // } else {
            //     $sendOtp['otp']->delete();
            //     return response()->json(['status' => false, 'message' => $sendOtp['response']['message'], 'statusCode' => $sendOtp['response']['code']], 422);
            // }
            
        // try {
        //     Mail::to($user)->send(new EmailConfirmation($user->id));
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
        

        } catch(Throwable $error){
            throw $error;
        }
        
    }

    /**
     * Display a listing of the resource.
     */
    public function loginUser(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                "phone" => "required_without:email",
                "email" => "required_without:phone",
                'password' => 'required',
            ]);

            if ($validator->fails()) {

                return Response(['message' => $validator->errors()], 401);
            }

            $user = $this->userService->query()->where('phone', $request->phone)->first();
            if(!$user){
                return Response(['message' => 'phone or password wrong'], 401);
            }
            if($user->phone_verified == 1){
                //Login Attempt with Phone
                if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
                    $user = Auth::user();

                    $success =  $user->createToken('bibaabo')->plainTextToken;

                    // return Response(['token' => $success], 200);
                    return (new UserResource($user))->additional([
                        'token' => $success,
                        'status' => true,
                        'message' => "Login Successful.",
                        'statusCode' => 200
                    ], Response::HTTP_OK);
                }
            }else{
                return Response(['message' => 'Phone no. not verified. Verify OTP.'], 401);
            }
            

            //Login Attempt with Email
            // elseif (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            //     $user = Auth::user();

            //     $success =  $user->createToken('bibaabo')->plainTextToken;

            //     return Response(['token' => $success], 200);
            // }

            return Response(['message' => 'phone or password wrong'], 401);

        }catch( Throwable $error){
            throw $error;
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function userDetails(): Response
    {
        if (Auth::check()) {

            $user = Auth::user();
            $user =  new UserResource($user);
            return Response(['data' => $user], 200);
        }

        return Response(['data' => 'Unauthorized'], 401);
    }

    /**
     * Display the specified resource.
     */
    public function logout(): Response
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        return Response(['data' => 'User Logout successfully.'], 200);
    }
}
