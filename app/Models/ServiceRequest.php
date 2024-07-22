<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    public $columnsWithTypes = [
        'user' => 'string',
        'kyc' => 'string',
        'service' => 'string',
        'title' => 'string',
        'title_id' => 'string',
        'type' => 'string',
        'type_id' => 'string',
        'description' => 'string',
        'form_fields' => 'string',
        'display' => 'string',
        'status' => 'string',
        'additional_note' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(Kyc::class, 'user');
    }

    public function kyc()
    {
        return $this->belongsTo(Kyc::class, 'kyc');
    }

    public function users()
    {
        return $this->belongsTo(Kyc::class, 'user');
    }

    public function kycs()
    {
        return $this->belongsTo(Kyc::class, 'kyc');
    }
}
