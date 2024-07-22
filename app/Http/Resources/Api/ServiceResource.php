<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends CommonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArrayWithoutNullValues($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'icon' => $this->imageUrl('icon'),
            'image' => $this->imageUrl('image'),
            'order' => $this->order,
            'display' => $this->display == 1,
            'smart' => $this->smart == 1,
            'additional' => $this->additionalService,
            'featured' => $this->featured == 1,
            'description' => $this->description,
            'createdAt' => date('F d, Y h:i A', strtotime($this->created_at)),
            'bankServiceTypes' => BankServiceTypeResource::collection($this->bankServiceTypeApi),
        ];
    }
}
