<?php

namespace App\Models;

use App\Custom\Contracts\ImageableContract;
use App\Custom\Traits\CreatedUpdatedBy;
use App\Custom\Traits\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BimaAccount extends Model implements ImageableContract
{
    use HasFactory;
    use Imageable;
    use CreatedUpdatedBy;
    use SoftDeletes;

    public $columnsWithTypes = [
        'title' => 'string',
        'slug' => 'string',
        'type' => 'string',
        'icon' => 'image',
        'image' => 'image',
        'order' => 'string',
        'display' => 'boolean',
        'parent' => 'integer',
        'child' => 'integer',
        'description' => 'string',
    ];

    public function getChildren($id)
    {
        return $this->query()->where('parent', $id)->get();
    }

    public function attributes()
    {
        return $this->morphMany(Attribute::class, 'model');
    }

    public function bimaAccountType()
    {
        return $this->hasMany(BimaAccountType::class, 'account_type');
    }

    public function bimaAccountTypeApi()
    {
        $bima = Bima::where('deleted_at', null)->where('display', 1)->pluck('id');
        return $this->hasMany(BimaAccountType::class, 'bima')->where('display', 1)->whereIn('bima', $bima);
    }
}
