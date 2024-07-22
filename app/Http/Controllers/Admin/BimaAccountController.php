<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BimaAccountRequest;
use App\Http\Resources\Admin\BimaAccountResource;
use App\Services\BimaAccountService;
use Illuminate\Http\Request;

class BimaAccountController extends CommonController
{
    //
    //
    /**
     * @var BimaAccountService
     */
    private $bimaAccountService;

    public function __construct(BimaAccountService $bimaAccountService)
    {
        $this->middleware('auth:admin');
        $this->bimaAccountService = $bimaAccountService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $account = $this->bimaAccountService->getForIndex(
            $this->paginationLimit
        );
        return BimaAccountResource::collection($account);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BimaAccountRequest $request)
    {
        //
        $data = $request->validated();
        $order = $this->bimaAccountService->query()->max('order') + 1;
        $request->merge(['order' => $order]);

        $store = $this->bimaAccountService->store($request->all());
        if ($store) {
            return new BimaAccountResource($store);
        } else {
            return failureResponse('Something Went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($account)
    {
        //
        $data = $this->bimaAccountService->findOrFail($account);
        return new BimaAccountResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BimaAccountRequest $request, $account)
    {
        //
        $update = $request->validated();
        $data  = $this->bimaAccountService->update($account, $update);
        return new BimaAccountResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($account)
    {
        //
        $findrecord = $this->bimaAccountService->findOrFail($account);
        $deleteRecord = $findrecord->delete();
        if ($deleteRecord) {
            return successResponse('success');
        } else {
            return failureResponse("Unable to perform action.");
        }
    }

    public function search(Request $request)
    {
        $data = $this->bimaAccountService->query()->where('title', 'LIKE', $request->searchText . '%')->paginate($this->paginationLimit);

        return BimaAccountResource::collection($data);
    }

    public function getBimaAccountTypes()
    {
        $account = $this->bimaAccountService->query()->get();
        return BimaAccountResource::collection($account);
    }
}
