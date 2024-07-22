<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends CommonResource
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
            'value' => $this->value            
        ];
    }
}
