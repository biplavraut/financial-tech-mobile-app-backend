<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class CommonController extends Controller
{
	protected $website = [];
	protected $paginationLimit = 10;

	// protected function forgetIndexCache()
	// {
	// 	Cache::forget("{$this->cacheKey}.index");
	// }
}
