<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BankLoanTypeRequest;
use App\Http\Resources\Admin\BankLoanTypeResource;
use App\Services\AttributeService;
use App\Services\LtypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BankLoanTypeController extends CommonController
{
    //
    //
    //

    //
    /**
     * @var LtypeService
     */
    private $bankLoanTypeService;

    /**
     * @var AttributeService
     */
    private $attributeService;

    public function __construct(LtypeService $bankLoanTypeService, AttributeService $attributeService)
    {
        $this->middleware('auth:admin');
        $this->bankLoanTypeService = $bankLoanTypeService;
        $this->attributeService = $attributeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $bankAccountType = $this->bankLoanTypeService->getForIndex(
            $this->paginationLimit
        );
        return BankLoanTypeResource::collection($bankAccountType);
    }

    /**
     * Display a listing of the resource.
     */
    public function types(Request $request)
    {
        //
        $bankAccountType = $this->bankLoanTypeService->query()->where('bank', $request->bank)->latest()->paginate(10);
        return BankLoanTypeResource::collection($bankAccountType);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BankLoanTypeRequest $request)
    {
        //
        $data = $request->validated();

        $store = $this->bankLoanTypeService->store(Arr::except($request->all(), ['attribute']));
        $count = 0;
        //dd($request->attribute);
        if (count((array)$request->attribute) > 0) {
            foreach ($request->attribute as $att) {
                //printf($att['id']);
                if (!isset($att['id'])) {
                    //$count++;
                    $this->attributeService->store([
                        'title' => $att['title'],
                        'value' => $att['value'],
                        'model_type' => get_class($store),
                        'model_id' => $store->id,
                    ]);
                }

                $count++;
            }
        }
        if ($store) {
            return new BankLoanTypeResource($store);
        } else {
            return failureResponse('Something Went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($bankAccountType)
    {
        //
        $data = $this->bankLoanTypeService->findOrFail($bankAccountType);
        return new BankLoanTypeResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BankLoanTypeRequest $request, $bankAccountType)
    {
        //
        $update = $request->validated();
        $data  = $this->bankLoanTypeService->update($bankAccountType, Arr::except($update, ['attribute']));
        if (count((array)$request->attribute) > 0) {
            $count = 0;
            //dd($request->attribute);
            foreach ($request->attribute as $att) {
                //printf($att['id']);
                if (!isset($att['id'])) {
                    //$count++;
                    $this->attributeService->store([
                        'title' => $att['title'],
                        'value' => $att['value'],
                        'model_type' => get_class($data),
                        'model_id' => $data->id,
                    ]);
                }

                $count++;
            }
        }
        return new BankLoanTypeResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($bankAccountType)
    {
        //
        $findrecord = $this->bankLoanTypeService->findOrFail($bankAccountType);
        $deleteRecord = $findrecord->delete();
        if ($deleteRecord) {
            return successResponse('success');
        } else {
            return failureResponse("Unable to perform action.");
        }
    }

    public function search(Request $request)
    {
        if ($request->bank) {
            $data = $this->bankLoanTypeService->query()->where('title', 'LIKE', $request->searchText . '%')->where('bank', $request->bank)->paginate($this->paginationLimit);
        } else {
            $data = $this->bankLoanTypeService->query()->where('title', 'LIKE', $request->searchText . '%')->paginate($this->paginationLimit);
        }

        return BankLoanTypeResource::collection($data);
    }
}