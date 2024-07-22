<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BankAccountTypeController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\BankLoanTypeController;
use App\Http\Controllers\Admin\BankServiceTypeController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BimaAccountController;
use App\Http\Controllers\Admin\BimaAccountTypeController;
use App\Http\Controllers\Admin\BimaController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KycController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MiscController;
use App\Http\Controllers\Admin\PlaceController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ServiceProviderController;
use App\Http\Controllers\Admin\ServiceRequestController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::name('admin.')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});



Route::redirect('/', '/admin/v1', 301);

Route::middleware('auth:admin')->group(function () {
    Route::get('v1/{param1?}/{param2?}/{param3?}', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::post('/change-password', [AdminController::class, 'changePassword'])->name('user.password.change.store');
    Route::post('/update-profile', [AdminController::class, 'updateProfile']);

    Route::apiResource('user', UserController::class);
    Route::post('/user/blocked', [UserController::class, 'updateBlocked']);

    // Banners
    Route::apiResource('/banner', BannerController::class);
    Route::get('/banner/get-data/{searchText}', [BannerController::class, 'search']);

    // Services 
    Route::get(
        '/service/get-all/{type}',
        [MiscController::class, 'getServiceTypes']
    );
    Route::apiResource('/service', ServiceController::class);
    Route::get('/service/get-data/{searchText}', [ServiceController::class, 'search']);

    // Account and Types 
    Route::get('/account/get-all/{type}',
        [MiscController::class, 'getAccountTypes']
    );

    Route::apiResource('/account', AccountController::class);
    Route::get('/account/get-data/{searchText}', [AccountController::class, 'search']);

    Route::get('/listAccount', [AccountController::class, 'getAccountList']);
    Route::post('/orderAccount', [AccountController::class, 'orderAccounts']);

    // eBank 
    Route::apiResource('/bank', BankController::class);
    Route::get('/bank/get-data/{searchText}', [BankController::class, 'search']);

    // Bank Branch
    Route::get('/bank/branch/{bank}', [BranchController::class, 'branch']);
    Route::apiResource('/branch', BranchController::class)->only('store','show', 'update', 'destroy');

    // Province, District, Municipality
    Route::get('/province', [PlaceController::class, 'province']);
    Route::get('/district/get-all', [PlaceController::class, 'district']);

    Route::get('/municipality', [PlaceController::class, 'municipalities']);
    Route::get('/municipality/get-filter/{district}', [PlaceController::class, 'filterrByDistrict']);

    // KYC
    Route::apiResource('/kyc', KycController::class);
    Route::get('/kyc/get-data/{searchText}', [KycController::class, 'search']);

    // Bank Account Types
    Route::get('/bank/bank-account-type/{bank}', [BankAccountTypeController::class, 'types']);
    Route::apiResource('/bank-account-type', BankAccountTypeController::class)->only('store', 'show', 'update', 'destroy');

    // Misc: Attribute, Account Types
    Route::get('/delete-attribute/{id}', [MiscController::class, 'deleteAttribute']);

    //Bank Service Types
    Route::get('/bank/bank-service-type/{bank}', [BankServiceTypeController::class, 'types']);
    Route::apiResource('/bank-service-type', BankServiceTypeController::class)->only('store', 'show', 'update', 'destroy');

    // eBima
    Route::apiResource('/bima', BimaController::class);
    Route::get('/bank/get-data/{searchText}', [BimaController::class, 'search']);

    // Bima Account and Types 
    Route::get(
        '/bima-account/get-all/{type}',
        [BimaAccountController::class, 'getBimaAccountTypes']
    );

    Route::apiResource('/bima-account', BimaAccountController::class);
    Route::get('/bima-account/get-data/{searchText}', [BimaAccountController::class, 'search']);

    // Bima Account Types
    Route::get('/bima/bima-account-type/{bima}', [BimaAccountTypeController::class, 'types']);
    Route::apiResource('/bima-account-type', BimaAccountTypeController::class)->only('store', 'show', 'update', 'destroy');

    // eLoan
    // Account and Types 
    Route::get(
        '/loan/get-all/{type}',
        [LoanController::class, 'getLoanTypes']
    );
    Route::apiResource('/loan', LoanController::class);
    Route::get('/loan/get-data/{searchText}', [LoanController::class, 'search']);

    // Bank Loan Types
    Route::get('/bank/bank-loan-type/{bank}', [BankLoanTypeController::class, 'types']);
    Route::apiResource('/bank-loan-type', BankLoanTypeController::class)->only('store', 'show', 'update', 'destroy');

    //  Service Request
    Route::apiResource('service-request', ServiceRequestController::class);
    Route::get('/service-request/get-data/{searchText}', [ServiceRequestController::class, 'search']);

    // Service providers 
    Route::apiResource('/service-provider', ServiceProviderController::class);
    Route::get('/service-provider/get-data/{searchText}', [ServiceProviderController::class, 'search']);

});