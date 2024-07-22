<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BimaResource extends CommonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArrayWithoutNullValues($request)
    {
        return [
            // 'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'routingNo' => $this->routing_no,
            'logo' => $this->imageUrl('logo'),
            'banner' => $this->imageUrl('banner'),
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'order' => $this->order,
            'display' => $this->display == 1,
            'featured' => $this->featured == 1,
            'rating' => $this->rating,
            'type' => $this->type,
            'lat' => $this->lat,
            'long' => $this->long,
            'address' => $this->address,
            'accountTypes' => $this->secondary_address,
            'description' => $this->description,
            'createdAt' => date('F d, Y h:i A', strtotime($this->created_at)),
            'attributes' => AttributeResource::collection($this->attributes),
        ];
    }
}
