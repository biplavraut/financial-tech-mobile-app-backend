<?php

namespace App\Services;

use App\Models\Attribute;

class AttributeService extends ModelService
{
    const MODEL = Attribute::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }
}
