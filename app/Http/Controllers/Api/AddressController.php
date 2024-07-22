<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddressRequest;
use App\Http\Resources\Api\AddressResource;
use App\Services\AddressService;
use Exception;
use Illuminate\Http\Request;

class AddressController extends CommonController
{
    //
    //
    //
    //
    /**
     * @var AddressService
     */
    private $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressRequest $request)
    {
        //
        try {
            $data = $request->validated();
            $request->merge(['user_id' => auth()->user()->id]);
            $store = $this->addressService->store($request->all());
            if ($store) {
                return new AddressResource($store);
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
    public function update(AddressRequest $request, $address)
    {
        //
        $update = $request->validated();
        $data  = $this->addressService->update($address, $update);
        return new AddressResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($address)
    {
        //
        $findrecord = $this->addressService->findOrFail($address);
        $deleteRecord = $findrecord->delete();
        if ($deleteRecord) {
            return successResponse('success');
        } else {
            return failureResponse("Unable to perform action.");
        }
    }
}
