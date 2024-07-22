<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BimaAccountResource;
use App\Services\BimaAccountService;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class BimaAccountController extends Controller
{
    //
    //
    /**
     * @var BimaAccountService
     */
    private $bimaAccountService;

    public function __construct(BimaAccountService $bimaAccountService)
    {
        $this->bimaAccountService = $bimaAccountService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $life = $this->bimaAccountService->query()->where('display', 1)->where('type','life')->get();
        $life =  BimaAccountResource::collection($life);
        $non_life = $this->bimaAccountService->query()->where('display', 1)->where('type', 'non-life')->get();
        $non_life =  BimaAccountResource::collection($non_life);
        $data = ['life' => $life, 'nonlife' => $non_life];
        return response()->json(['status' => true, 'data' => $data, 'statusCode' => 200], 200);
        //return ["data" => [$data]];
    }
}
