<?php

namespace App\Services;

use App\Models\Family;

class FamilyService extends ModelService
{
    const MODEL = Family::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }
}
