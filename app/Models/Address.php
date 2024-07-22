<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public $columnsWithTypes = [
        'user_id' => 'string',
        'kyc_id' => 'string',
        'type' => 'string',
        'province_no' => 'string',
        'province' => 'string',
        'zone' => 'string',
        'district' => 'string',
        'vdc_municipality' => 'string',
        'ward' => 'string',
        'street_tole' => 'string',
        'house_no' => 'string',
        'tel' => 'string',
        'mobile' => 'string',
        'email' => 'string',
    ];

    public function kyc()
    {
        return $this->belongsTo(Kyc::class, 'kyc_id');
    }
}
