<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends CommonResource
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
            'type' => $this->type,
            'provinceNo' => $this->province_no,
            'province' => $this->province,
            'zone' => $this->zone,
            'district' => $this->district,
            'vdcMunicipality' => $this->vdc_municipality,
            'ward' => $this->ward,
            'streetTole' => $this->street_tole,
            'houseNo' => $this->house_no,
            'tel' => $this->tel,
            'mobile' => $this->mobile,
            'email' => $this->email,
        ];
    }
}
