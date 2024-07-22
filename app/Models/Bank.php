<?php

namespace App\Models;

use App\Custom\Contracts\ImageableContract;
use App\Custom\Traits\CreatedUpdatedBy;
use App\Custom\Traits\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model implements ImageableContract
{
    use HasFactory;
    use Imageable;
    use CreatedUpdatedBy;
    use SoftDeletes;

    public $columnsWithTypes = [
        'title' => 'string',
        'slug' => 'string',
        'routing_no' => 'string',
        'logo' => 'image',
        'banner' => 'image',
        'phone' => 'string',
        'mobile' => 'string',
        'order' => 'string',
        'display' => 'boolean',
        'featured' => 'boolean',
        'rating' => 'string',
        'type' => 'string',
        'lat' => 'string',
        'long' => 'string',
        'address' => 'string',
        'secondary_address' => 'json',
        'description' => 'string'
    ];

    public function branches(){
        return $this->hasMany(Branch::class, 'bank');
    }

    public function getSecondaryAddressAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function bankAccountType()
    {
        return $this->hasMany(BankAccountType::class, 'bank');
    }

    public function bankServiceType()
    {
        return $this->hasMany(BankServiceType::class, 'bank');
    }

    public function attributes()
    {
        return $this->morphMany(Attribute::class, 'model');
    }

    public function bankAccountTypeList()
    {
        return $this->hasMany(BankAccountType::class, 'bank')->where('display', 1);
    }

}