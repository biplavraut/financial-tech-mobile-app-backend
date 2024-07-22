<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends CommonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArrayWithoutNullValues($request)
    {
        return [
            'bank' => $this->bank,
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'order' => $this->order,
            'display' => $this->display == 1,
            'locker' => $this->locker == 1,
            'atm' => $this->atm == 1,
            'headOffice' => $this->head_office == 1,
            'district' => $this->district,
            'municipality' => $this->municipality,
            'province' => $this->province,
            'lat' => $this->lat,
            'long' => $this->long,
            'address' => $this->address,
            'description' => $this->description,
            'createdAt' => date('F d, Y h:i A', strtotime($this->created_at)),
        ];
    }
}
