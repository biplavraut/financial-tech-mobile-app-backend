<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Admin\CommonResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends CommonResource
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
            'description' => $this->description,
            'createdAt' => date('F d, Y h:i A', strtotime($this->created_at)),
            'bankLoanTypes' => BankLoanTypeResource::collection($this->bankLoanTypeApi),
        ];
    }
}
