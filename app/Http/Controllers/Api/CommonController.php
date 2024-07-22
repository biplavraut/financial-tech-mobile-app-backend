<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    protected $paginationLimit = 10;
    protected $expiresAt = 60;

    public function __construct()
    {
    }
}
