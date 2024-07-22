<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserLog;
use Auth;

class UserLogService extends ModelService
{
    const MODEL = UserLog::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }

    public function storeUserLog($request, $remarks = "No remarks Attached")
    {
        $userLog = new UserLog();
        $userLog->user_id = $request->userId ? $request->userId : Auth::user()->id;
        $userLog->device_name = $request->deviceName;
        $userLog->device_type = $request->deviceType;
        $userLog->device_token = $request->deviceToken;
        $userLog->lat = $request->lat;
        $userLog->long = $request->long;
        $userLog->remarks = $remarks;
        $userLog->save();
    }
}
