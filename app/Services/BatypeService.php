<?php

namespace App\Services;

use App\Models\BimaAccountType;

class BatypeService extends ModelService
{
    const MODEL = BimaAccountType::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }
}
