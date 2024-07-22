<?php

namespace App\Http\Controllers\Api;

use App\Custom\Helper\EmailValidator;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Api\UserResource;
use App\Services\UserLogService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends CommonController
{
    //
    public function __construct(protected UserService $userService, protected UserLogService $userLogService)
    {
        $this->userService = $userService;
        $this->userLogService = $userLogService;
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currentPassword' => 'required|string',
            'newPassword' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                $errors = $messages[0];
            }
            return failureResponse($errors, 418, 418);
        }

        if (Hash::check($request->currentPassword, $request->user()->password)) {
            if ($request->user()->update(['password' => bcrypt($request->newPassword)])) {
                $userLog = $this->userLogService->storeUserLog($request, "User Password Update");
                return successResponse("Your password has been changed successfully.");
            } else {
                return failureResponse("Sorry, your password could not be changed. Please try again later.", 418, 418);
            }
        }
        return failureResponse("Your old password did not match. Please try again.", 418, 418);
    }

    public function updateProfile(UpdateUserRequest $request)
    {

        //Email Domain Validation
        if ($request->email) {
            $response = new EmailValidator($request->email);

            if (!$response->validate()) {
                return failureResponse("Invalid email.", 418, 418);
            }
        }

        $data['salutation'] = $request->salutation;
        $data['first_name'] = $request->firstName;
        $data['middle_name'] = $request->middleName;
        $data['last_name'] = $request->lastName;
        $data['gender'] = $request->gender;
        $data['image'] = $request->image;
        $data['dob'] = $request->dob;
        $data['email']    = $request->email;


        try {
            $user = $this->userService->update($request->user()->id, $data);
            //dd( $user);
            if ($user) {
                $userLog = $this->userLogService->storeUserLog($request, "User Profile Update");
            }
        } catch (\Throwable $th) {
            return $th;
            return failureResponse("Something went wrong while updating profile. Please try again.", 422, 422);
        }


        // if ($user->email && $user->verified == 0) {
        //     try {
        //         Mail::to($user)->send(new VerifyUserEmail($user->email_token));
        //     } catch (\Throwable $th) {
        //         //throw $th;
        //     }
        // }

        return (new UserResource($user))->additional([
            'status' => true,
            'message' => 'Your profile has been updated successfully.',
            'statusCode' => 200
        ], Response::HTTP_OK);
    }
}
