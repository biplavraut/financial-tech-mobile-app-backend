<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\KycResource;
use App\Services\KycService;
use Illuminate\Http\Request;

class KycController extends CommonController
{
    //
    //
    //
    //
    /**
     * @var KycService
     */
    private $kycService;

    public function __construct(KycService $kycService)
    {
        $this->middleware('auth:admin');
        $this->kycService = $kycService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $kycs = $this->kycService->getForIndex(
            $this->paginationLimit
        );
        return KycResource::collection($kycs);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kyc)
    {
        //
        $kyc_verified = $request->status == "verified" ? 1 : 0;
        $data  = $this->kycService->update($kyc, ["status" => $request->status, "kyc_verified" => $kyc_verified]);
        return new KycResource($data);
    }

    /**
     * Display the specified resource.
     */
    public function show($kyc)
    {
        //
        $data = $this->kycService->findOrFail($kyc);
        return new KycResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kyc)
    {
        //
        $findrecord = $this->kycService->findOrFail($kyc);
        $deleteRecord = $findrecord->delete();
        if ($deleteRecord) {
            return successResponse('success');
        } else {
            return failureResponse("Unable to perform action.");
        }
    }

    public function search(Request $request)
    {
        $data = $this->kycService->query()->where('kyc_code', 'LIKE', '%'.  $request->searchText . '%')->paginate($this->paginationLimit);

        return KycResource::collection($data);
    }
}
