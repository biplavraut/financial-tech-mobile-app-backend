<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends CommonResource
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
            'kycId' => $this->kyc_id,
            'type' =>  $this->type,
            'number' =>  $this->number,
            'officeOfIssuance' =>  $this->office_of_issuance,
            'dateOfIssue' =>  $this->date_of_issue,
            'issueDistrict' =>  $this->issue_district,
            'front' => $this->imageUrl('front'),
            'back' => $this->imageUrl('back'),
            'selfiee' => $this->imageUrl('selfiee'),
            'validTill' => $this->valid_till
        ];
    }
}
