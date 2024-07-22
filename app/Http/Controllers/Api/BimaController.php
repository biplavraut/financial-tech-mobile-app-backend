<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BimaResource;
use App\Services\BimaService;
use Illuminate\Http\Request;

class BimaController extends Controller
{
    //
    //
    //
    /**
     * @var BimaService
     */
    private $bimaService;

    public function __construct(BimaService $bimaService)
    {
        $this->bimaService = $bimaService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $account = $this->bimaService->query()->where('display', 1)->get();
        return BimaResource::collection($account);
    }
}
