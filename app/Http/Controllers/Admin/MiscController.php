<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AccountResource;
use App\Http\Resources\Admin\ServiceResource;
use App\Services\AccountService;
use App\Services\AttributeService;
use App\Services\ServiceService;
use Illuminate\Http\Request;

class MiscController extends CommonController
{
    //

    /**
     * @var AttributeService
     */
    private $attributeService;

    /**
     * @var AccountService
     */
    private $accountService;

    /**
     * @var ServiceServce
     */
    private $serviceService;

    public function __construct(AttributeService $attributeService, AccountService $accountService, ServiceService $serviceService)
    {
        $this->middleware('auth:admin');
        $this->attributeService = $attributeService;
        $this->accountService = $accountService;
        $this->serviceService = $serviceService;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteAttribute($id)
    {
        //
        $findrecord = $this->attributeService->findOrFail($id);
        $deleteRecord = $findrecord->delete();
        if ($deleteRecord) {
            return successResponse('success');
        } else {
            return failureResponse("Unable to perform action.");
        }
    }

    public function getAccountTypes(){
        $account = $this->accountService->query()->get();
        return AccountResource::collection($account);
    }

    public function getServiceTypes()
    {
        $account = $this->serviceService->query()->get();
        return ServiceResource::collection($account);
    }
}
