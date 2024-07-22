<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ServiceProviderResource;
use App\Services\ServiceProviderService;
use Illuminate\Http\Request;

class ServiceProviderController extends CommonController
{
    //
    //
    /**
     * @var ServiceProviderService
     */
    private $serviceProviderService;

    public function __construct(ServiceProviderService $serviceProviderService)
    {
        $this->serviceProviderService = $serviceProviderService;
    }

    public function index()
    {
        //
        $data = $this->serviceProviderService->query()->where('display', 1)->get();
        $data =  ServiceProviderResource::collection($data)->groupBy('type');
        return response()->json(['status' => true, 'data' => $data, 'statusCode' => 200], 200);
        //return $data;
    }
}
