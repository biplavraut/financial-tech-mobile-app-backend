<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FamilyRequest;
use App\Http\Resources\Api\FamilyResource;
use App\Services\FamilyService;
use Exception;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    //
    //
    //
    //
    //
    /**
     * @var FamilyService
     */
    private $familyService;

    public function __construct(FamilyService $familyService)
    {
        $this->familyService = $familyService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FamilyRequest $request)
    {
        //
        try {
            $data = $request->validated();
            $request->merge(['user_id' => auth()->user()->id]);
            $store = $this->familyService->store($request->all());
            if ($store) {
                return new FamilyResource($store);
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
    public function update(FamilyRequest $request, $family)
    {
        //
        $update = $request->validated();
        $data  = $this->familyService->update($family, $update);
        return new FamilyResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($family)
    {
        //
        $findrecord = $this->familyService->findOrFail($family);
        $deleteRecord = $findrecord->delete();
        if ($deleteRecord) {
            return successResponse('success');
        } else {
            return failureResponse("Unable to perform action.");
        }
    }
}
