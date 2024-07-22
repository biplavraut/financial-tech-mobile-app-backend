<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DocumentRequest;
use App\Http\Resources\Api\DocumentResource;
use App\Services\DocumentService;
use Exception;
use Illuminate\Http\Request;

class DocumentController extends CommonController
{
    //
    //
    //
    //
    //
    /**
     * @var DocumentService
     */
    private $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DocumentRequest $request)
    {
        //
        try {
            
            $data = $request->validated();
            //dd($data);
            $request->merge(['user_id' => auth()->user()->id]);
            $store = $this->documentService->store($request->all());
            if ($store) {
                return new DocumentResource($store);
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
    public function update(DocumentRequest $request, $document)
    {
        //
        $update = $request->validated();
        $data  = $this->documentService->update($document, $update);
        return new DocumentResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($document)
    {
        //
        $findrecord = $this->documentService->findOrFail($document);
        $deleteRecord = $findrecord->delete();
        if ($deleteRecord) {
            return successResponse('success');
        } else {
            return failureResponse("Unable to perform action.");
        }
    }
}
