<?php

namespace App\Models;

use App\Custom\Contracts\ImageableContract;
use App\Custom\Traits\CreatedUpdatedBy;
use App\Custom\Traits\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bima extends Model implements ImageableContract
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

    public function getSecondaryAddressAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function bimaAccountType()
    {
        return $this->hasMany(BimaAccountType::class, 'bima');
    }

    public function attributes()
    {
        return $this->morphMany(Attribute::class, 'model');
    }

    public function bimaAccountTypeApi()
    {
        $bima = Bima::where('deleted_at', null)->where('display', 1)->pluck('id');
        return $this->hasMany(BimaAccountType::class, 'bima')->where('display', 1)->whereIn('bima', $bima);
    }
}
