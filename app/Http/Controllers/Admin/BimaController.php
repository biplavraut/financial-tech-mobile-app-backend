<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BimaRequest;
use App\Http\Resources\Admin\BimaResource;
use App\Services\AttributeService;
use App\Services\BimaService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BimaController extends CommonController
{
    //
    //
    /**
     * @var BimaService
     */
    private $bimaService;

    /**
     * @var AttributeService
     */
    private $attributeService;

    public function __construct(BimaService $bimaService, AttributeService $attributeService)
    {
        $this->middleware('auth:admin');
        $this->bimaService = $bimaService;
        $this->attributeService = $attributeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $bank = $this->bimaService->getForIndex(
            $this->paginationLimit
        );
        return BimaResource::collection($bank);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BimaRequest $request)
    {
        //

        $data = $request->validated();
        $order = $this->bimaService->query()->max('order') + 1;
        $request->merge(['order' => $order]);

        //$store = $this->bimaService->store($request->all());
        $bank = $this->bimaService->store(Arr::except($request->all(), ['attribute']));
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
                        'model_type' => get_class($bank),
                        'model_id' => $bank->id,
                    ]);
                }

                $count++;
            }
        }

        if ($bank) {
            return new BimaResource($bank);
        } else {
            return failureResponse('Something Went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($bank)
    {
        //
        $data = $this->bimaService->findOrFail($bank);
        return new BimaResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BimaRequest $request, $bank)
    {


        $data = $request->validated();
        //$data  = $this->bimaService->update($bank, $update);

        $bank = $this->bimaService->update($bank, Arr::except($data, ['attribute']));

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
                        'model_type' => get_class($bank),
                        'model_id' => $bank->id,
                    ]);
                }

                $count++;
            }
        }

        //return $data;
        return new BimaResource($bank);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($bank)
    {
        //
        $findrecord = $this->bimaService->findOrFail($bank);
        $deleteRecord = $findrecord->delete();
        if ($deleteRecord) {
            return successResponse('success');
        } else {
            return failureResponse("Unable to perform action.");
        }
    }

    public function search(Request $request)
    {
        $data = $this->bimaService->query()->where('title', 'LIKE', $request->searchText . '%')->paginate($this->paginationLimit);

        return BimaResource::collection($data);
    }
}
