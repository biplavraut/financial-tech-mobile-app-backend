<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ServicereqRequest;
use App\Http\Resources\Api\ServicereqResource;
use App\Services\ServicereqService;
use Exception;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    //
    //
    //
    //
    //
    /**
     * @var ServicereqService
     */
    private $serviceRequestService;

    public function __construct(ServicereqService $serviceRequestService)
    {
        $this->serviceRequestService = $serviceRequestService;
    }

    /**
     * Display a listing of the resource.
     */
    public function getServiceRequest()
    {
        //
        $data = $this->serviceRequestService->query()->where('user', auth()->user()->id)->first();
        return ServicereqResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServicereqRequest $request)
    {
        //
        try {
            $data = $request->validated();
            $request->merge(['user' => auth()->user()->id]);
            $store = $this->serviceRequestService->store($request->all());
            if ($store) {
                return new ServicereqResource($store);
            } else {
                return failureResponse('Something Went wrong');
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServicereqRequest $request, $address)
    {
        //
        $update = $request->validated();
        $data  = $this->serviceRequestService->update($address, $update);
        return new ServicereqResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($address)
    {
        //
        $findrecord = $this->serviceRequestService->findOrFail($address);
        $deleteRecord = $findrecord->delete();
        if ($deleteRecord) {
            return successResponse('success');
        } else {
            return failureResponse("Unable to perform action.");
        }
    }
}
