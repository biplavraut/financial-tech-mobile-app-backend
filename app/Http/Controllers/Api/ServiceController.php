<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ServiceResource;
use App\Services\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends CommonController
{
    //
    /**
     * @var ServiceService
     */
    private $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $banners = $this->serviceService->query()->where('display', 1)->get();
        return ServiceResource::collection($banners);
    }
}
