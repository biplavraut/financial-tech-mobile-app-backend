<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankLoanTypeResource extends CommonResource
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
            'bank' => $this->bank,
            'title'             => $this->title,
            'slug'            => $this->slug,
            'image'             => $this->imageUrl('image'),
            'display' => $this->display == 1,
            'description' => $this->description,
            'createdAt' => date('F d, Y h:i A', strtotime($this->created_at)),
            'loanType' => $this->loan_type,
            'banks' => new BankResource($this->banks),
            'loanTypes' => new LoanResource($this->loanTypes),
            'attributes' => $this->attributes,

        ];
    }
}
