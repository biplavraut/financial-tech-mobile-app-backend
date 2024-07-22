<?php

namespace App\Models;

use App\Custom\Contracts\ImageableContract;
use App\Custom\Traits\CreatedUpdatedBy;
use App\Custom\Traits\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccountType extends Model implements ImageableContract
{
    use HasFactory;
    use Imageable;
    use CreatedUpdatedBy;

    public $columnsWithTypes = [
        'bank' => 'string',
        'account_type' => 'string',
        'title' => 'string',
        'slug' => 'string',
        'image' => 'image',
        'display' => 'boolean',
        'description' => 'string'
    ];

    public function banks()
    {
        return $this->belongsTo(Bank::class, 'bank');
    }

    public function accountTypes()
    {
        return $this->belongsTo(Account::class, 'account_type');
    }

    public function attributes()
    {
        return $this->morphMany(Attribute::class, 'model');
    }


}
