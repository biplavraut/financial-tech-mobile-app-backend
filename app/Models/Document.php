<?php

namespace App\Models;

use App\Custom\Contracts\ImageableContract;
use App\Custom\Traits\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model implements ImageableContract
{
    use HasFactory;
    use Imageable;

    public $columnsWithTypes = [
        'user_id' => 'string',
        'kyc_id' => 'string',
        'type' => 'string',
        'number' => 'string',
        'office_of_issuance' => 'string',
        'date_of_issue' => 'string',
        'issue_district' => 'string',
        'front' => 'image',
        'back' => 'image',
        'selfiee' => 'image',
        'valid_till' => 'string'
    ];

    public function kyc()
    {
        return $this->belongsTo(Kyc::class, 'kyc_id');
    }
}
