<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoanRequest;
use App\Http\Resources\Admin\LoanResource;
use App\Services\LoanService;
use Illuminate\Http\Request;

class LoanController extends CommonController
{
    //
    /**
     * @var LoanService
     */
    private $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->middleware('auth:admin');
        $this->loanService = $loanService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $account = $this->loanService->getForIndex(
            $this->paginationLimit
        );
        return LoanResource::collection($account);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoanRequest $request)
    {
        //
        $data = $request->validated();
        $order = $this->loanService->query()->max('order') + 1;
        $request->merge(['order' => $order]);

        $store = $this->loanService->store($request->all());
        if ($store) {
            return new LoanResource($store);
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
        $data = $this->loanService->findOrFail($account);
        return new LoanResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LoanRequest $request, $account)
    {
        //
        $update = $request->validated();
        $data  = $this->loanService->update($account, $update);
        return new LoanResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($account)
    {
        //
        $findrecord = $this->loanService->findOrFail($account);
        $deleteRecord = $findrecord->delete();
        if ($deleteRecord) {
            return successResponse('success');
        } else {
            return failureResponse("Unable to perform action.");
        }
    }

    public function search(Request $request)
    {
        $data = $this->loanService->query()->where('title', 'LIKE', $request->searchText . '%')->paginate($this->paginationLimit);

        return LoanResource::collection($data);
    }

    public function getLoanTypes()
    {
        $account = $this->loanService->query()->get();
        return LoanResource::collection($account);
    }

}
