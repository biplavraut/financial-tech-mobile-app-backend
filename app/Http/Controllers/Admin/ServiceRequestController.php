<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ServicereqResource;
use App\Services\ServicereqService;
use Illuminate\Http\Request;

class ServiceRequestController extends CommonController
{
    //
    //
    /**
     * @var ServicereqService
     */
    private $serviceRequestService;

    public function __construct(ServicereqService $serviceRequestService)
    {
        $this->middleware('auth:admin');
        $this->serviceRequestService = $serviceRequestService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = $this->serviceRequestService->getForIndex(
            $this->paginationLimit
        );
        return ServicereqResource::collection($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $ser)
    {
        //
        $data  = $this->serviceRequestService->update($ser, ["status" => $request->status]);
        return new ServicereqResource($data);
    }

    /**
     * Display the specified resource.
     */
    public function show($ser)
    {
        //
        $data = $this->serviceRequestService->findOrFail($ser);
        return new ServicereqResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ser)
    {
        //
        $findrecord = $this->serviceRequestService->findOrFail($ser);
        $deleteRecord = $findrecord->delete();
        if ($deleteRecord) {
            return successResponse('success');
        } else {
            return failureResponse("Unable to perform action.");
        }
    }

    public function search(Request $request)
    {
        $data = $this->serviceRequestService->query()->where('kyc_code', 'LIKE', '%' .  $request->searchText . '%')->paginate($this->paginationLimit);

        return ServicereqResource::collection($data);
    }
}
