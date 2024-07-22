<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AccountResource;
use App\Http\Resources\Api\BankAccountTypeResource;
use App\Http\Resources\Api\BankloanTypeResource;
use App\Http\Resources\Api\BankResource;
use App\Http\Resources\Api\BankServiceTypeResource;
use App\Http\Resources\Api\BimaAccountResource;
use App\Http\Resources\Api\BimaAccountTypeResource;
use App\Http\Resources\Api\BimaResource;
use App\Http\Resources\Api\LoanResource;
use App\Http\Resources\Api\SearchBankLoanTypeResource;
use App\Http\Resources\Api\ServiceResource;
use App\Services\AccountService;
use App\Services\BankService;
use App\Services\BatypeService;
use App\Services\BimaAccountService;
use App\Services\BimaService;
use App\Services\LoanService;
use App\Services\LtypeService;
use App\Services\ServiceService;
use App\Services\StypeService;
use App\Services\TypeService;
use Illuminate\Http\Request;

class MiscController extends CommonController
{
    //
    /**
     * @var BankService
     */
    private $bankService;
    /**
     * @var AccountService
     */
    private $accountService;

    /**
     * @var ServiceService
     */
    private $serviceService;

    //
    /**
     * @var LoanService
     */
    private $loanService;

    //
    /**
     * @var TypeService
     */
    private $bankAccountTypeService;

    //
    /**
     * @var LtypeService
     */
    private $bankLoanTypeService;

    //
    /**
     * @var StypeService
     */
    private $bankServiceTypeService;

    //
    /**
     * @var BimaService
     */
    private $bimaService;

    //
    /**
     * @var BimaAccountService
     */
    private $bimaAccountService;

    //
    /**
     * @var BatypeService
     */
    private $bimaAccountTypeService;

    public function __construct(BankService $bankService, 
                TypeService $bankAccountTypeService, 
                AccountService $accountService,
                ServiceService $serviceService, 
                LoanService $loanService, 
                LtypeService $bankLoanTypeService,
                StypeService $bankServiceTypeService,
                BimaService $bimaService,
                BimaAccountService $bimaAccountService,
                BatypeService $bimaAccountTypeService)
    {
        $this->bankService = $bankService;
        $this->bankAccountTypeService = $bankAccountTypeService;
        $this->accountService = $accountService;
        $this->serviceService = $serviceService;
        $this->loanService = $loanService;
        $this->bankLoanTypeService = $bankLoanTypeService;
        $this->bankServiceTypeService = $bankServiceTypeService;
        $this->bimaService = $bimaService;
        $this->bimaAccountService = $bimaAccountService;
        $this->bimaAccountTypeService = $bimaAccountTypeService;
    }
    public function search(Request $request)
    {
        $bank = [];
        $bankAccountTypes = [];
        $bankServiceTypes = [];
        $service = [];       
        $account = [];
        $loan = [];
        $bankLoanTypes = [];
        $bima = [];
        $bimaAccounts = [];
        $bimaAccountTypes = [];

        if($request->type == 'bank' || $request->type == 'all'){
            $bank = $this->bankService->query()->where('title', 'LIKE', '%' . $request->searchText . '%')->where('display', 1)->get();
            $bank =  BankResource::collection($bank);

            $bankAccountTypes = $this->bankAccountTypeService->query()->where('title', 'LIKE', '%' . $request->searchText . '%')->where('display', 1)->get();
            $bankAccountTypes =  BankAccountTypeResource::collection($bankAccountTypes);

            $bankServiceTypes = $this->bankServiceTypeService->query()->where('title', 'LIKE', '%' . $request->searchText . '%')->where('display', 1)->get();
            $bankServiceTypes =  BankServiceTypeResource::collection($bankServiceTypes);
        }
        if ($request->type == 'service' || $request->type == 'bank' || $request->type == 'all') {
            $service = $this->serviceService->query()->where('title', 'LIKE', '%' .  $request->searchText . '%')->where('display', 1)->get();
            $service = ServiceResource::collection($service);
        }

        if ($request->type == 'account' || $request->type == 'bank' || $request->type == 'all') {
            $account = $this->accountService->query()->where('title', 'LIKE', '%' .  $request->searchText . '%')->where('display', 1)->get();
            $account = AccountResource::collection($account);
        }
        if ($request->type == 'loan' || $request->type == 'all') {
            $loan = $this->loanService->query()->where('title', 'LIKE', '%' .  $request->searchText . '%')->where('display', 1)->get();
            $loan =  LoanResource::collection($loan);

            $bankLoanTypes = $this->bankLoanTypeService->query()->where('title', 'LIKE', '%' .  $request->searchText . '%')->where('display', 1)->get();
            $bankLoanTypes =  SearchBankLoanTypeResource::collection($bankLoanTypes);
        }

        if ($request->type == 'bima' || $request->type == 'all') {
            $bima = $this->bimaService->query()->where('title', 'LIKE', '%' .  $request->searchText . '%')->where('display', 1)->get();
            $bima =  BimaResource::collection($bima);

            $bimaAccounts = $this->bimaAccountService->query()->where('title', 'LIKE', '%' .  $request->searchText . '%')->where('display', 1)->get();
            $bimaAccounts =  BimaAccountResource::collection($bimaAccounts);

            $bimaAccountTypes = $this->bimaAccountTypeService->query()->where('title', 'LIKE', '%' .  $request->searchText . '%')->where('display', 1)->get();
            $bimaAccountTypes =  BimaAccountTypeResource::collection($bimaAccountTypes);
        }
        $data = [
            'bank' => $bank, 
            'bankAccountTypes' => $bankAccountTypes,
            'bankServiceTypes' => $bankServiceTypes,
            'service' => $service, 
            'account' => $account, 
            'loan' => $loan, 
            'bankLoanTypes' => $bankLoanTypes,
            'bima' => $bima,
            'bimaAccounts' => $bimaAccounts,
            'bimaAccountTypes' => $bimaAccountTypes
        ];
        return response()->json(['status' => true, 'data' => $data, 'statusCode' => 200], 200);
    }
}
