<?php

namespace App\Models;

use App\Custom\Contracts\ImageableContract;
use App\Custom\Traits\CreatedUpdatedBy;
use App\Custom\Traits\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kyc extends Model implements ImageableContract
{
    use HasFactory;
    use Imageable;
    use CreatedUpdatedBy;

    public $columnsWithTypes = [
        'user_id' => 'string',
        'kyc_code' => 'string',
        'salutation'        => 'string',
        'first_name'        => 'string',
        'middle_name'        => 'string',
        'last_name'        => 'string',
        'gender' => 'string',
        'nationality' => 'string',
        'marital_status' => 'string',
        'dob_bs' => 'string',
        'dob_ad' => 'string',
        'self' => 'boolean',
        'other' => 'boolean',
        'pp_photo' => 'image',
        'map' => 'image',
        'country_code'       => 'string',
        'phone'       => 'string',
        'mobile' => 'string',
        'email'       => 'string',
        'kyc_verified' => 'string',
        'peps_member' => 'string',
        'peps_detail' => 'string',
        'beneficial' => 'boolean',
        'beneficial_name' => 'string',
        'beneficial_ctzn_no' => 'string',
        'beneficial_relation' => 'string',
        'beneficial_address' => 'string',
        'beneficial_contact' => 'string',
        'decleration' => 'string',
        'additional_note' => 'string',
        'status' => 'string'        
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function address()
    {
        return $this->hasMany(Address::class);
    }
    public function document()
    {
        return $this->hasMany(Document::class);
    }

    public function family()
    {
        return $this->hasMany(Family::class);
    }
    public function occupation()
    {
        return $this->hasMany(Occupation::class);
    }
}
