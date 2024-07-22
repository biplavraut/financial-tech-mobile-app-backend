<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Api\AddressResource;
use App\Http\Resources\Api\DocumentResource;
use App\Http\Resources\Api\FamilyResource;
use App\Http\Resources\Api\OccupationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KycResource extends CommonResource
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
            'user' =>  new UserResource($this->user),
            'kycCode' => $this->kyc_code,
            'salutation' => $this->salutation,
            'firstName' => $this->first_name,
            'middleName' => $this->middle_name,
            'lastName' => $this->last_name,
            'gender' => $this->gender ?? '',
            'nationality' => $this->nationality,
            'maritalStatus' => $this->marital_status,
            'dobBs' => $this->dob_bs,
            'dobAd' => $this->dob_ad,
            'self' => $this->self == 1,
            'other' => $this->other == 1,
            'ppPhoto' => $this->imageUrl('pp_photo'),
            'map' => $this->imageUrl('map'),
            'countryCode' => $this->country_code,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'email' => $this->email ?? '',
            'kycVerified' => $this->kyc_verified == 1,

            'pepsMember' => $this->peps_member == 1,
            'pepsDetail' => $this->peps_detail,
            'beneficial' => $this->beneficial == 1,
            'beneficialName' => $this->beneficial_name,
            'beneficialCtznNo' => $this->beneficial_ctzn_no,
            'beneficialRelation' => $this->beneficial_relation,
            'beneficialAddress' => $this->beneficial_address,
            'beneficialContact' => $this->beneficial_contact,

            'decleration' => $this->decleration,
            'additionalNote' => $this->additional_note,
            'status' => $this->status,

            'createdAt' => $this->created_at,

            'address' => AddressResource::collection($this->address),
            'document' => DocumentResource::collection($this->document),
            'occupation' => OccupationResource::collection($this->occupation),
            'family' => FamilyResource::collection($this->family),

        ];
    }
}
