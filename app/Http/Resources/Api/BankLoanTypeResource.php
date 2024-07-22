<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankloanTypeResource extends CommonResource
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
            'title'             => $this->title,
            'slug'            => $this->slug,
            'image'             => $this->imageUrl('image'),
            'display' => $this->display == 1,
            'description' => $this->description,
            'createdAt' => date('F d, Y h:i A', strtotime($this->created_at)),
            'bank' => new BankResource($this->banks),
            'attributes' => AttributeResource::collection($this->attributes),

        ];
    }
}
