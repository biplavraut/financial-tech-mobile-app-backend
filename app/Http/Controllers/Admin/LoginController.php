<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\AdminService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    /**
     * @var AdminService
     */
    private $adminService;

    /**
     * Create a new controller instance.
     *
     * @param UserService $adminService
     */
    public function __construct(AdminService $adminService)
    {
        $this->middleware('guest')->except('logout');
        $this->adminService = $adminService;
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'verified' => 1], $request->get('remember'))) {

            return redirect()->route('admin.dashboard');
        }
        return  $this->sendFailedLoginResponse($request);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $errorMessage = [];
        try {
            $admin = $this->adminService->findOrFailBy('email', $request->email);

            if (!$admin->isVerified()) {
                $errorMessage['verified'] = [Lang::get('auth.not_verified')];
            }

            $errorMessage['email'] =  [trans('auth.failed')];
        } catch (\Throwable $th) {
            $errorMessage['email'] =  [trans('auth.failed')];
        }

        throw ValidationException::withMessages($errorMessage);
    }

    public function logout(Request $request)
    {
        auth()->guard('admin')->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

    protected function loggedOut(Request $request)
    {
        return redirect()->route('admin.login.form');
    }
}
