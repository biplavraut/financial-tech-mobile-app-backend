<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BankRequest;
use App\Http\Resources\Admin\BankResource;
use App\Models\Bank;
use App\Services\AttributeService;
use App\Services\BankService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BankController extends CommonController
{
    //
    /**
     * @var BankService
     */
    private $bankService;

    /**
     * @var AttributeService
     */
    private $attributeService;

    public function __construct(BankService $bankService, AttributeService $attributeService)
    {
        $this->middleware('auth:admin');
        $this->bankService = $bankService;
        $this->attributeService = $attributeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $bank = $this->bankService->getForIndex(
            $this->paginationLimit
        );
        return BankResource::collection($bank);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BankRequest $request)
    {
        //
        
        $data = $request->validated();
        $order = $this->bankService->query()->max('order') + 1;
        $request->merge(['order' => $order]);

        //$store = $this->bankService->store($request->all());
        $bank = $this->bankService->store(Arr::except($request->all(), ['attribute']));
        if(count((array)$request->attribute) > 0){
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
            return new BankResource($bank);
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
        $data = $this->bankService->findOrFail($bank);
        return new BankResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BankRequest $request, $bank)
    {
        
        
        $data = $request->validated();
        //$data  = $this->bankService->update($bank, $update);

        $bank = $this->bankService->update($bank, Arr::except($data, ['attribute']));

        if (count((array)$request->attribute) > 0) {
            $count = 0;
            //dd($request->attribute);
            foreach ($request->attribute as $att) {
                //printf($att['id']);
                if(!isset($att['id'])){
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
        return new BankResource($bank);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($bank)
    {
        //
        $findrecord = $this->bankService->findOrFail($bank);
        $deleteRecord = $findrecord->delete();
        if ($deleteRecord) {
            return successResponse('success');
        } else {
            return failureResponse("Unable to perform action.");
        }
    }

    public function search(Request $request)
    {
        $data = $this->bankService->query()->where('title', 'LIKE', '%'. $request->searchText . '%')->paginate($this->paginationLimit);

        return BankResource::collection($data);
    }
}
