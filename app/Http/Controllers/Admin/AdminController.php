<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AdminService;
use App\Http\Controllers\Controller;
use App\Notifications\SettingsUpdated;
use App\Http\Resources\Admin\AdminResource;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Notifications\PasswordChanged;

class AdminController extends CommonController
{
    /**
     * @var AdminService
     */
    private $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->middleware('auth:admin');

        $this->adminService = $adminService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        return view('admin.dashboard.home');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $admin = auth()->guard('admin')->user();

        $status = $this->adminService->changePassword($admin, $request);

        $data['message'] = 'Your password has been changed successfully.';


        if ($status['status']) {
            Notification::send($admin, new PasswordChanged($data));
        }

        return response()->json($status);
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string',
            'image'    => 'nullable|file|max:5120|mimes:jpg,jpeg,png',
            'email'    => 'required|email',
        ]);

        $admin = auth()->guard('admin')->user();

        $admin  = $this->adminService->updateByModel($admin, $data);

        return new AdminResource($admin);
    }
}
