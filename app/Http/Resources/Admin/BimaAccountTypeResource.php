<?php

namespace App\Http\Resources\Admin;

use App\Models\BimaAccountType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BimaAccountTypeResource extends CommonResource
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
            'bima' => $this->bima,
            'title'             => $this->title,
            'slug'            => $this->slug,
            'image'             => $this->imageUrl('image'),
            'display' => $this->display == 1,
            'description' => $this->description,
            'createdAt' => date('F d, Y h:i A', strtotime($this->created_at)),
            'accountType' => $this->account_type,
            'bimas' => new BimaResource($this->bimas),
            'accountTypes' => new BimaAccountResource($this->accountTypes),
            'attributes' => $this->attributes,
        ];
    }
}
