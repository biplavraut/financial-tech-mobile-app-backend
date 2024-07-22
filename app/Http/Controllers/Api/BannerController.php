<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BannerResource;
use App\Http\Resources\Api\BannersResource;
use App\Services\BannerService;
use Illuminate\Http\Request;

class BannerController extends CommonController
{
    //
    /**
     * @var BannerService
     */
    private $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $banners = $this->bannerService->query()->where('display', 1)->get()->groupBy('page');
        //return $banners;
        return BannersResource::collection($banners);

    }
}
