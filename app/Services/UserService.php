<?php

namespace App\Services;

use App\Models\User;

class UserService extends ModelService
{
    const MODEL = User::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }

    public function getNotification($user)
    {
        return $user->notifications;
    }

    public function register($request){
        $user = new User();

        // $user->first_name = $request->firstName;
        // $user->middle_name = $request->middleName;
        // $user->last_name = $request->lastName;
        // $user->email = $request->email;
        $user->country_code = $request->countryCode;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->last_login_at = now();
        $user->image = 'user-avatar.png';
        $user->refer_code = randomAlphaNumericString(5);
        $user->save();
        return $user;
    }
}