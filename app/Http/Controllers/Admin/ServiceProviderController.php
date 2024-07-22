<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceProviderRequest;
use App\Http\Resources\Admin\ServiceProviderResource;
use App\Services\ServiceProviderService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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
        $this->middleware('auth:admin');
        $this->serviceProviderService = $serviceProviderService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $bank = $this->serviceProviderService->getForIndex(
            $this->paginationLimit
        );
        return ServiceProviderResource::collection($bank);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceProviderRequest $request)
    {
        //

        $data = $request->validated();
        $order = $this->serviceProviderService->query()->max('order') + 1;
        $request->merge(['order' => $order]);

        $store = $this->serviceProviderService->store($request->all());

        if ($store) {
            return new ServiceProviderResource($store);
        } else {
            return failureResponse('Something Went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($bank)
    {
        //
        $data = $this->serviceProviderService->findOrFail($bank);
        return new ServiceProviderResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceProviderRequest $request, $serviceProvider)
    {


        $data = $request->validated();
        $data  = $this->serviceProviderService->update($serviceProvider, $data);

        //return $data;
        return new ServiceProviderResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($bank)
    {
        //
        $findrecord = $this->serviceProviderService->findOrFail($bank);
        $deleteRecord = $findrecord->delete();
        if ($deleteRecord) {
            return successResponse('success');
        } else {
            return failureResponse("Unable to perform action.");
        }
    }

    public function search(Request $request)
    {
        $data = $this->serviceProviderService->query()->where('title', 'LIKE', '%' . $request->searchText . '%')->paginate($this->paginationLimit);

        return ServiceProviderResource::collection($data);
    }
}
