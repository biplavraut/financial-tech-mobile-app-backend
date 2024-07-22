<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Admin\CommonResource;
use Carbon\Carbon;

class UserResource extends CommonResource
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
			'id' => $this->id,
			'name'             => $this->full_name,
			'email'            => $this->email,
			'phone'            => $this->phone,
			'avatar'             => $this->imageUrl('profile_photo_path'),
			'blocked' => $this->blocked == 1,
			'phone_verified' => $this->phone_verified == 1,
			'created_at' => date('F d, Y h:i A', strtotime($this->created_at)),
			'last_login_at' => $this->last_login_at ? Carbon::parse($this->last_login_at)->diffForHumans() : 'N\\A'
		];
	}
}
