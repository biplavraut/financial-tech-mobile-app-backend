<?php

namespace App\Models;

use App\Custom\Contracts\ImageableContract;
use App\Custom\Traits\CreatedUpdatedBy;
use App\Custom\Traits\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceProvider extends Model implements ImageableContract
{
    use HasFactory;
    use Imageable;
    use CreatedUpdatedBy;
    use SoftDeletes;

    public $columnsWithTypes = [
        'title' => 'string',
        'slug' => 'string',
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
}
