<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Admin\CommonResource;

class CompanyResource extends CommonResource
{
	/**
	 * Transform the resource into an array by changing null values to empty string.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return array
	 */
	public function toArrayWithoutNullValues($request)
	{
		return [
			'name'             => "Bibaabo",
			'email'            => "info@bibaabo.com",
			'phone'            => "+977 01 4811111",
			'established_date' => "2023",
			'address'          => "address",
			'about'            => "about",
			'logo'             => url("logo/logo.png"),
			'logo_big' => url("logo/logo.png"),
			'logo_mini' => url("logo/logo.png"),
			'tac'             => "Terms",
			'policy'             => "Policy",
		];
	}
}
