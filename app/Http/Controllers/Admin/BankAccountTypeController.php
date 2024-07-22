<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BankAccountTypeRequest;
use App\Http\Resources\Admin\BankAccountTypeResource;
use App\Services\AttributeService;
use App\Services\BankAccountTypeService;
use App\Services\TypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BankAccountTypeController extends CommonController
{
    //
    //

    //
    /**
     * @var TypeService
     */
    private $bankAccountTypeService;

    /**
     * @var AttributeService
     */
    private $attributeService;

    public function __construct(TypeService $bankAccountTypeService, AttributeService $attributeService)
    {
        $this->middleware('auth:admin');
        $this->bankAccountTypeService = $bankAccountTypeService;
        $this->attributeService = $attributeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $bankAccountType = $this->bankAccountTypeService->getForIndex(
            $this->paginationLimit
        );
        return BankAccountTypeResource::collection($bankAccountType);
    }

    /**
     * Display a listing of the resource.
     */
    public function types(Request $request)
    {
        //
        $bankAccountType = $this->bankAccountTypeService->query()->where('bank', $request->bank)->latest()->paginate(10);
        return BankAccountTypeResource::collection($bankAccountType);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BankAccountTypeRequest $request)
    {
        //
        $data = $request->validated();

        $store = $this->bankAccountTypeService->store(Arr::except($request->all(), ['attribute']));
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
            return new BankAccountTypeResource($store);
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
        $data = $this->bankAccountTypeService->findOrFail($bankAccountType);
        return new BankAccountTypeResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BankAccountTypeRequest $request, $bankAccountType)
    {
        //
        $update = $request->validated();
        $data  = $this->bankAccountTypeService->update($bankAccountType, Arr::except($update, ['attribute']));
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
        return new BankAccountTypeResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($bankAccountType)
    {
        //
        $findrecord = $this->bankAccountTypeService->findOrFail($bankAccountType);
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
            $data = $this->bankAccountTypeService->query()->where('title', 'LIKE', $request->searchText . '%')->where('bank', $request->bank)->paginate($this->paginationLimit);
        } else {
            $data = $this->bankAccountTypeService->query()->where('title', 'LIKE', $request->searchText . '%')->paginate($this->paginationLimit);
        }

        return BankAccountTypeResource::collection($data);
    }
}
