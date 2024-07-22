<?php

namespace App\Models;

use App\Custom\Contracts\ImageableContract;
use App\Custom\Traits\CreatedUpdatedBy;
use App\Custom\Traits\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BimaAccountType extends Model implements ImageableContract
{
    use HasFactory;
    use Imageable;
    use CreatedUpdatedBy;

    public $columnsWithTypes = [
        'bima' => 'string',
        'account_type' => 'string',
        'title' => 'string',
        'slug' => 'string',
        'image' => 'image',
        'display' => 'boolean',
        'description' => 'string'
    ];

    public function bimas()
    {
        return $this->belongsTo(Bima::class, 'bima');
    }

    public function accountTypes()
    {
        return $this->belongsTo(BimaAccount::class, 'account_type');
    }

    public function attributes()
    {
        return $this->morphMany(Attribute::class, 'model');
    }

}
