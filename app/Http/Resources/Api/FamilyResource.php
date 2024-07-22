<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FamilyResource extends CommonResource
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
            'relation' => $this->relation,
            'fullName' => $this->full_name,
            'citizenshipNo' => $this->citizenship_no,
            'placeOfIssue' => $this->place_of_issue,
            'dateOfIssue' => $this->date_of_issue,
            'contact' => $this->contact
        ];
    }
}
