<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BankServiceTypeRequest;
use App\Http\Resources\Admin\BankServiceTypeResource;
use App\Services\AttributeService;
use App\Services\StypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BankServiceTypeController extends CommonController
{
    //
    //
    //

    //
    /**
     * @var StypeService
     */
    private $bankServiceTypeService;

    /**
     * @var AttributeService
     */
    private $attributeService;

    public function __construct(StypeService $bankServiceTypeService, AttributeService $attributeService)
    {
        $this->middleware('auth:admin');
        $this->bankServiceTypeService = $bankServiceTypeService;
        $this->attributeService = $attributeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $bankAccountType = $this->bankServiceTypeService->getForIndex(
            $this->paginationLimit
        );
        return BankServiceTypeResource::collection($bankAccountType);
    }

    /**
     * Display a listing of the resource.
     */
    public function types(Request $request)
    {
        //
        $bankAccountType = $this->bankServiceTypeService->query()->where('bank', $request->bank)->latest()->paginate(10);
        return BankServiceTypeResource::collection($bankAccountType);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BankServiceTypeRequest $request)
    {
        //
        $data = $request->validated();

        $store = $this->bankServiceTypeService->store(Arr::except($request->all(), ['attribute']));
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
            return new BankServiceTypeResource($store);
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
        $data = $this->bankServiceTypeService->findOrFail($bankAccountType);
        return new BankServiceTypeResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BankServiceTypeRequest $request, $bankAccountType)
    {
        //
        $update = $request->validated();
        $data  = $this->bankServiceTypeService->update($bankAccountType, Arr::except($update, ['attribute']));
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
        return new BankServiceTypeResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($bankAccountType)
    {
        //
        $findrecord = $this->bankServiceTypeService->findOrFail($bankAccountType);
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
            $data = $this->bankServiceTypeService->query()->where('title', 'LIKE', $request->searchText . '%')->where('bank', $request->bank)->paginate($this->paginationLimit);
        } else {
            $data = $this->bankServiceTypeService->query()->where('title', 'LIKE', $request->searchText . '%')->paginate($this->paginationLimit);
        }

        return BankServiceTypeResource::collection($data);
    }
}
