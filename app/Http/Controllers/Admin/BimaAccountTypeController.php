<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BimaAccountTypeRequest;
use App\Http\Resources\Admin\BimaAccountTypeResource;
use App\Services\AttributeService;
use App\Services\BatypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BimaAccountTypeController extends CommonController
{
    //
    //
    //

    //
    /**
     * @var BatypeService
     */
    private $bimaAccountTypeService;

    /**
     * @var AttributeService
     */
    private $attributeService;

    public function __construct(BatypeService $bimaAccountTypeService, AttributeService $attributeService)
    {
        $this->middleware('auth:admin');
        $this->bimaAccountTypeService = $bimaAccountTypeService;
        $this->attributeService = $attributeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $bimaAccountType = $this->bimaAccountTypeService->getForIndex(
            $this->paginationLimit
        );
        //return $bimaAccountType;
        return BimaAccountTypeResource::collection($bimaAccountType);
    }

    /**
     * Display a listing of the resource.
     */
    public function types(Request $request)
    {
        //
        $bimaAccountType = $this->bimaAccountTypeService->query()->where('bima', $request->bima)->latest()->paginate(10);
        return BimaAccountTypeResource::collection($bimaAccountType);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BimaAccountTypeRequest $request)
    {
        //
        $data = $request->validated();

        $store = $this->bimaAccountTypeService->store(Arr::except($request->all(), ['attribute']));
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
            return new BimaAccountTypeResource($store);
        } else {
            return failureResponse('Something Went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($bimaAccountType)
    {
        //
        $data = $this->bimaAccountTypeService->findOrFail($bimaAccountType);
        return new BimaAccountTypeResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BimaAccountTypeRequest $request, $bimaAccountType)
    {
        //
        $update = $request->validated();
        $data  = $this->bimaAccountTypeService->update($bimaAccountType, Arr::except($update, ['attribute']));
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
        return new BimaAccountTypeResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($bankAccountType)
    {
        //
        $findrecord = $this->bimaAccountTypeService->findOrFail($bankAccountType);
        $deleteRecord = $findrecord->delete();
        if ($deleteRecord) {
            return successResponse('success');
        } else {
            return failureResponse("Unable to perform action.");
        }
    }

    public function search(Request $request)
    {
        if ($request->bima) {
            $data = $this->bimaAccountTypeService->query()->where('title', 'LIKE', $request->searchText . '%')->where('bima', $request->bima)->paginate($this->paginationLimit);
        } else {
            $data = $this->bimaAccountTypeService->query()->where('title', 'LIKE', $request->searchText . '%')->paginate($this->paginationLimit);
        }

        return BimaAccountTypeResource::collection($data);
    }
}
