<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicereqResource extends CommonResource
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
            'kyc' => new KycResource($this->kycs),
            'user' => new UserResource($this->users),
            'service' => $this->service,
            'title' => $this->title,
            'title_id' => $this->title_id,
            'type' => $this->type,
            'typeId' => $this->type_id,
            'description' => $this->description,
            'status' => $this->status,
            'formFields' => $this->form_fields,
            'createdAt' => $this->created_at,
        ];
    }
}
