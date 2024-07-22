<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    use HasFactory;

    public $columnsWithTypes = [
        'user_id' => 'string',
        'kyc_id' => 'string',
        'type' => 'string',
        'office' => 'string',
        'address' => 'string',
        'position' => 'string',
        'est_annual_income' => 'string',
        'est_annual_turnover' => 'string',
        'tel' => 'string'
    ];

    public function kyc()
    {
        return $this->belongsTo(Kyc::class, 'kyc_id');
    }
}
