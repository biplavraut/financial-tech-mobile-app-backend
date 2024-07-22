<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    public $columnsWithTypes = [
        'title' => 'string',
        'value' => 'string',
        'model_id' => 'string',
        'model_type' => 'string',
    ];

    public function model()
    {
        return $this->morphTo('model');
    }

    public function getMe($id)
    {
        return $this->where('model_id', $id)->limit(1)->get();
    }
}
