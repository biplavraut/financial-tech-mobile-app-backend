<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\LoanResource;
use App\Services\LoanService;
use Illuminate\Http\Request;

class LoanController extends CommonController
{
    //
    //
    /**
     * @var LoanService
     */
    private $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $loan = $this->loanService->query()->where('display', 1)->get();
        return LoanResource::collection($loan);
    }
}
