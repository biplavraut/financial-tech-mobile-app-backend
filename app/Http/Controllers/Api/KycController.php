<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\KycRequest;
use App\Http\Resources\Api\KycResource;
use App\Services\KycService;
use Exception;
use Illuminate\Http\Request;

class KycController extends CommonController
{
    //
    //
    //
    /**
     * @var KycService
     */
    private $kycService;

    public function __construct(KycService $kycService)
    {
        $this->kycService = $kycService;
    }
    /**
     * Display a listing of the resource.
     */
    public function getKyc($id)
    {
        //
        $kyc = $this->kycService->query()->where('id', $id)->first();
        return new KycResource($kyc);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KycRequest $request)
    {
        //
        try{
            $data = $request->validated();
            $request->merge(['user_id' => auth()->user()->id, 'kyc_code' => 'KYC-' . strtoupper(randomAlphaNumericString(5)).'-' . time()]);
            //dd($request);
            $store = $this->kycService->store($request->all());
            if ($store) {
                return new KycResource($store);
            } else {
                return failureResponse('Something Went wrong');
            }
        }catch(Exception $e){
            return $e;
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KycRequest $request, $kyc)
    {
        //
        $update = $request->validated();
        $data  = $this->kycService->update($kyc, $update);
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

}
