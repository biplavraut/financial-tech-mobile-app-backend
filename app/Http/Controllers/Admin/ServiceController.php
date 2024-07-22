<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Http\Resources\Admin\ServiceResource;
use App\Models\Service;
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
        $this->middleware('auth:admin');
        $this->serviceService = $serviceService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $services = $this->serviceService->getForIndex(
            $this->paginationLimit
        );
        return ServiceResource::collection($services);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request)
    {
        //dd($request);
        //
        $data = $request->validated();
        $order = $this->serviceService->query()->max('order') + 1;
        $request->merge(['order' => $order]);

        $store = $this->serviceService->store($request->all());
        if ($store) {
            return new ServiceResource($store);
        } else {
            return failureResponse('Something Went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($service)
    {
        //
        $data = $this->serviceService->findOrFail($service);
        return new ServiceResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceRequest $request, $service)
    {
        //
        $update = $request->validated();
        $data  = $this->serviceService->update($service, $update);
        return new ServiceResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($service)
    {
        //
        $findrecord = $this->serviceService->findOrFail($service);
        $deleteRecord = $findrecord->delete();
        if ($deleteRecord) {
            return successResponse('success');
        } else {
            return failureResponse("Unable to perform action.");
        }
    }

    public function search(Request $request)
    {
        $data = $this->serviceService->query()->where('title', 'LIKE', $request->searchText . '%')->paginate($this->paginationLimit);

        return ServiceResource::collection($data);
    }
}
