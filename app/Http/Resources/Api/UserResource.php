<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends CommonResource
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
            'salutation' => $this->salutation,
            'firstName' => $this->first_name,
            'middleName' => $this->middle_name,
            'lastName' => $this->last_name,
            'fullName' => $this->fullName,
            'gender' => $this->gender ?? '',
            'countryCode' => $this->country_code,
            'phone' => $this->phone,
            'phoneVerified' => (bool)$this->phone_verified,
            'email' => $this->email ?? '',
            'emailVerifiedAt' => $this->email_verified_at ?? '',
            'image' => $this->imageUrl('image'),
            'dob' => $this->dob ?? '',            
            'referCode' => $this->refer_code,
            'blocked' => (bool) $this->blocked,
            'kycSelf' => new KycResource($this->myKyc->first()),
            'allKyc' => KycResource::collection($this->kyc),
            'kycCompleted' => "50%"
            // 'token' => auth()->user()->token
        ];
    }
}
