<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;
    public $columnsWithTypes = [
        'user_id' => 'string',
        'kyc_id' => 'string',
        'relation' => 'string',
        'full_name' => 'string',
        'citizenship_no' => 'string',
        'place_of_issue' => 'string',
        'date_of_issue' => 'string',
        'contact' => 'string'
    ];

    public function kyc()
    {
        return $this->belongsTo(Kyc::class, 'kyc_id');
    }
}
