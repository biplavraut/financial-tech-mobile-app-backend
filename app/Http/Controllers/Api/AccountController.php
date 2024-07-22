<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AccountResource;
use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends CommonController
{
    //
    /**
     * @var AccountService
     */
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $account = $this->accountService->query()->where('display', 1)->get();
        return AccountResource::collection($account);
    }
}
