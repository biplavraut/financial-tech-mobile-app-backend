<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\BimaAccountController;
use App\Http\Controllers\Api\BimaController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\FamilyController;
use App\Http\Controllers\Api\KycController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\MiscController;
use App\Http\Controllers\Api\NepseController;
use App\Http\Controllers\Api\OccupationController;
use App\Http\Controllers\Api\OtpController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ServiceProviderController;
use App\Http\Controllers\Api\ServiceRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// OTP - Resend OTP - No Auth
Route::prefix('otp')->group(function () {
    Route::post('send', [OtpController::class, 'sendOtp'])->name('send-otp');
    Route::post('verify', [OtpController::class, 'verifyOtp'])->name('verify-otp');
    Route::post('forgot-password', [AuthController::class, 'forgotPasswordOtp'])->name('forget-password-otp');
    Route::post('forgot-password-update', [AuthController::class, 'updateForgotPassword']);
});

// Authentication
Route::post('login', [AuthController::class, 'loginUser']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    // Auth
    Route::get('user', [AuthController::class, 'userDetails']);
    Route::get('logout', [AuthController::class, 'logout']);

    // Auth User OTP Request
    Route::get('request-otp', [OtpController::class, 'sendOtp']);
    Route::get('verify-otp', [OtpController::class, 'verifyOtp']);

    // User Updates
    Route::post('update-password', [CustomerController::class, 'updatePassword']);
    Route::post('update-profile', [CustomerController::class, 'updateProfile']);

    // User KYC
    Route::post('kyc', [KycController::class, 'store']);
    Route::post('kyc/{id}', [KycController::class, 'update']);
    Route::get('kyc/{id}', [KycController::class, 'getKyc']);
    Route::delete('kyc/{id}', [KycController::class, 'destroy']);

    // User KYC Documents
    Route::post('document', [DocumentController::class, 'store']);
    Route::post('document/{id}', [DocumentController::class, 'update']);
    Route::delete('document/{id}', [DocumentController::class, 'destroy']);

    // User KYC Address
    Route::post('address', [AddressController::class, 'store']);
    Route::post('address/{id}', [AddressController::class, 'update']);
    Route::delete('address/{id}', [AddressController::class, 'destroy']);    

    // User KYC Occupation
    Route::post('occupation', [OccupationController::class, 'store']);
    Route::post('occupation/{id}', [OccupationController::class, 'update']);
    Route::delete('occupation/{id}', [OccupationController::class, 'destroy']);

    // User KYC Families
    Route::post('family', [FamilyController::class, 'store']);
    Route::post('family/{id}', [FamilyController::class, 'update']);
    Route::delete('family/{id}', [FamilyController::class, 'destroy']);

    //User Updates


    // User Service Request
    Route::post('service-request', [ServiceRequestController::class, 'store']);
    Route::post('service-request/{id}', [ServiceRequestController::class, 'update']);
    Route::get('service-request', [ServiceRequestController::class, 'getServiceRequest']);
    Route::delete('service-request/{id}', [ServiceRequestController::class, 'destroy']);
});

Route::get('banner', [BannerController::class, 'index']);
Route::get('service', [ServiceController::class, 'index']);
Route::get('account', [AccountController::class, 'index']);
Route::get('bank', [BankController::class, 'index']);
Route::get('account-type/{account}', [MiscController::class, 'accountType']);

Route::get('bima-account', [BimaAccountController::class, 'index']);
Route::get('bima', [BimaController::class, 'index']);

Route::get('loan', [LoanController::class, 'index']);

Route::get('search/{type}/{searchText}', [MiscController::class, 'search']);

Route::get('service-provider', [ServiceProviderController::class, 'index']);

// NEPSE
Route::get('/nepse/market', [NepseController::class, 'market']);
Route::get('/nepse/topGainer', [NepseController::class, 'topGainer']);
Route::get('/nepse/topLoser', [NepseController::class, 'topLoser']);
Route::get('/nepse/subIndices', [NepseController::class, 'subIndices']);
Route::get('/nepse/securitiesListing', [NepseController::class, 'securitiesListing']);
Route::get('/nepse/securityDailyTradeStat', [NepseController::class, 'securityDailyTradeStat']);
