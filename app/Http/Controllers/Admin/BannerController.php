<?php

namespace App\Http\Controllers\Admin;

use App\Services\BannerService;
use App\Models\Banner;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerRequest;
use App\Http\Resources\Admin\BannerResource;
use Illuminate\Http\Request;

class BannerController extends CommonController
{
    /**
     * @var BannerService
     */
    private $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->middleware('auth:admin');
        $this->bannerService = $bannerService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $banners = $this->bannerService->getForIndex(
            $this->paginationLimit
        );
        return BannerResource::collection($banners);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerRequest $request)
    {
        //dd($request);
        //
        $data = $request->validated();

        $store = $this->bannerService->store($request->all());
        if ($store) {
            return new BannerResource($store);
        } else {
            return failureResponse('Something Went wrong');
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show($banner)
    {
        //
        $data = $this->bannerService->findOrFail($banner);
        return new BannerResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerRequest $request, $banner)
    {
        //
        $update = $request->validated();
        $data  = $this->bannerService->update($banner, $update);
        return new BannerResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($banner)
    {
        //
        $findrecord = $this->bannerService->findOrFail($banner);
        $deleteRecord = $findrecord->delete();
        if ($deleteRecord) {
            return successResponse('success');
        } else {
            return failureResponse("Unable to perform action.");
        }
    }

    public function search(Request $request)
    {
        $data = $this->bannerService->query()->where('title', 'LIKE', $request->searchText . '%')->paginate($this->paginationLimit);

        return BannerResource::collection($data);
    }
}
