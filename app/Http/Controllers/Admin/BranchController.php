<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BranchRequest;
use App\Http\Resources\Admin\BranchResource;
use App\Services\BranchService;
use Illuminate\Http\Request;

class BranchController extends CommonController
{
    //

    //
    /**
     * @var BranchService
     */
    private $branchService;

    public function __construct(BranchService $branchService)
    {
        $this->middleware('auth:admin');
        $this->branchService = $branchService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $branch = $this->branchService->getForIndex(
            $this->paginationLimit
        );
        return BranchResource::collection($branch);
    }

    /**
     * Display a listing of the resource.
     */
    public function branch(Request $request)
    {
        //
        $branch = $this->branchService->query()->where('bank', $request->bank)->latest()->paginate(10);
        return BranchResource::collection($branch);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BranchRequest $request)
    {
        //
        $headOffice = $this->branchService->query()->where('head_office', 1)->first();
        $data = $request->validated();
        $order = $this->branchService->query()->max('order') + 1;
        $request->merge(['order' => $order]);

        $store = $this->branchService->store($request->all());
        if($store->head_office == 1 && $headOffice){
            $headOffice->update(['head_office' => 0]);
        }

        if ($store) {
            return new BranchResource($store);
        } else {
            return failureResponse('Something Went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($branch)
    {
        //
        $data = $this->branchService->findOrFail($branch);
        return new BranchResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BranchRequest $request, $branch)
    {
        //
        $headOfficeBefore = $this->branchService->query()->where('head_office', 1)->where('id', "!=", $branch)->first();
        $update = $request->validated();
        $data  = $this->branchService->update($branch, $update);
        if ($data->head_office == 1 && $headOfficeBefore) {
            $headOfficeBefore->update(['head_office' => 0]);
        }
        return new BranchResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($branch)
    {
        //
        $findrecord = $this->branchService->findOrFail($branch);
        $deleteRecord = $findrecord->delete();
        if ($deleteRecord) {
            return successResponse('success');
        } else {
            return failureResponse("Unable to perform action.");
        }
    }

    public function search(Request $request)
    {
        if($request->bank){
            $data = $this->branchService->query()->where('title', 'LIKE', $request->searchText . '%')->where('bank', $request->bank)->paginate($this->paginationLimit);

        }else{
            $data = $this->branchService->query()->where('title', 'LIKE', $request->searchText . '%')->paginate($this->paginationLimit);
        }

        return BranchResource::collection($data);
    }
}
