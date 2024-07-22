<?php

namespace App\Models;

use App\Custom\Contracts\ImageableContract;
use App\Custom\Traits\CreatedUpdatedBy;
use App\Custom\Traits\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model implements ImageableContract
{
    use HasFactory;
    use Imageable;
    use CreatedUpdatedBy;
    use SoftDeletes;

    public $columnsWithTypes = [
        'title' => 'string',
        'slug' => 'string',
        'icon' => 'image',
        'image' => 'image',
        'order' => 'string',
        'display' => 'boolean',
        'smart' => 'boolean',
        'additional' => 'boolean',
        'featured' => 'boolean',
        'description' => 'string',
    ];

    public function getAdditionalServiceAttribute()
    {
        return $this->additional == 1 ? true : false;
    }
    public function bankServiceType()
    {
        return $this->hasMany(BankServiceType::class, 'service_type');
    }

    public function bankServiceTypeApi(){
        $bank = Bank::where('deleted_at', null)->where('display', 1)->pluck('id');
        return $this->hasMany(BankServiceType::class, 'service_type')->where('display', 1)->whereIn('bank', $bank);
    }
}
