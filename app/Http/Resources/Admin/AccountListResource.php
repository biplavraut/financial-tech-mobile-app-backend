<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'title'  => $this->title,
            'parent' => $this->parent,
            'child' => $this->child,
            'order' => $this->order,
            'children' => AccountListResource::collection($this->getChildren($this->id))
        ];
    }
}
