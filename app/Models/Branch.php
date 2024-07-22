<?php

namespace App\Models;

use App\Custom\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;
    use SoftDeletes;

    protected $fillable = ['head_office'];

    public $columnsWithTypes = [
        'bank' => 'string',
        'title' => 'string',
        'slug' => 'string',
        'phone' => 'string',
        'mobile' => 'string',
        'order' => 'string',
        'display' => 'boolean',
        'locker' => 'boolean',
        'atm' => 'boolean',
        'head_office' => 'boolean',
        'district' => 'string',
        'municipality' => 'string',
        'province' => 'string',
        'lat' => 'string',
        'long' => 'string',
        'address' => 'string',
        'description' => 'string'
    ];

    public function bank(){
        return $this->belongsTo(Bank::class, 'bank');
    }

    public function provinces(){
        return $this->belongsTo(Province::class, 'province');
    }

    public function districts(){
        return $this->belongsTo(District::class, 'district');
    }

    public function municipalities()
    {
        return $this->belongsTo(Municipality::class, 'municipality');
    }
}
