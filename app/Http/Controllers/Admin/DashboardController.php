<?php

namespace App\Http\Controllers\Admin;

use App\Services\UserService;
use App\Services\AdminService;
use App\Http\Resources\Admin\AdminResource;
use App\Http\Resources\Admin\CompanyResource;

class DashboardController extends CommonController
{
    /**
     * @var AdminService
     */
    private $adminService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var VendorService
     */
    private $vendorService;

    public function __construct(AdminService $adminService, UserService $userService)
    {
        //parent::__construct();
        $this->adminService = $adminService;
        $this->userService = $userService;
    }

    public function index($param1 = null, $param2 = null, $param3 = null)
    {
        $this->website['counts'] = [
            'users' => $this->userService->getCount(),
            'admins' => $this->adminService->getCount(),
            'thisMonth'    => [
                'users' => $this->userService->thisMonthData(),
                'admins' => $this->adminService->thisMonthData(),
            ],
        ];

        if (request()->ajax()) {
            return response()->json(['data' => $this->website['counts']]);
        }
        $admin = auth()->guard('admin')->user();

        $company = array();

        $this->website['authUser'] = new AdminResource($admin);
        $this->website['company']  = new CompanyResource($company);

        $data['last_login_at'] = now();

        $admin  = $this->adminService->updateByModel($admin, $data);


        return view('admin.dashboard.home', $this->website);
    }
}
