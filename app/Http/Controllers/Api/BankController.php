<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BankResource;
use App\Services\BankService;
use Illuminate\Http\Request;

class BankController extends CommonController
{
    //
    //
    /**
     * @var BankService
     */
    private $bankService;

    public function __construct(BankService $bankService)
    {
        $this->bankService = $bankService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $account = $this->bankService->query()->where('display', 1)->get();
        return BankResource::collection($account);
    }
}
