<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OccupationResource extends CommonResource
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
            'office' => $this->office,
            'address' => $this->address,
            'position' => $this->position,
            'estAnnualIncome' => $this->est_annual_income,
            'estAnnualTurnover' => $this->est_annual_turnover,
            'tel' => $this->tel
        ];
    }
}
