<?php

namespace App\Http\Resources\Admin;

class AdminResource extends CommonResource
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
			'id'    => $this->id,
			'name'  => $this->name,
			'email' => $this->email,
			'type'  => $this->type,
			// 'image' => $this->profile_photo_url,
			'image' => 'https://ui-avatars.com/api/?name=' . $this->name . '&color=random&background=random&rounded=true',
			'verified' => $this->verified == 1,
			'last_active' => $this->last_active_at ? $this->last_active_at->diffForHumans() : 'N\\A',
			'created_at' => date('F d, Y h:i A', strtotime($this->created_at))
		];
	}
}
