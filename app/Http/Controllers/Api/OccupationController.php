<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OccupationRequest;
use App\Http\Resources\Api\OccupationResource;
use App\Services\OccupationService;
use Exception;
use Illuminate\Http\Request;

class OccupationController extends Controller
{
    //
    //
    //
    //
    //
    /**
     * @var OccupationService
     */
    private $occupationService;

    public function __construct(OccupationService $occupationService)
    {
        $this->occupationService = $occupationService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OccupationRequest $request)
    {
        //
        try {
            $data = $request->validated();
            $request->merge(['user_id' => auth()->user()->id]);
            $store = $this->occupationService->store($request->all());
            if ($store) {
                return new OccupationResource($store);
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
    public function update(OccupationRequest $request, $occupation)
    {
        //
        $update = $request->validated();
        $data  = $this->occupationService->update($occupation, $update);
        return new OccupationResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($occupation)
    {
        //
        $findrecord = $this->occupationService->findOrFail($occupation);
        $deleteRecord = $findrecord->delete();
        if ($deleteRecord) {
            return successResponse('success');
        } else {
            return failureResponse("Unable to perform action.");
        }
    }
}
