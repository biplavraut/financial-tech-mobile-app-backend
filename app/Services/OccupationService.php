<?php

namespace App\Services;

use App\Models\Occupation;

class OccupationService extends ModelService
{
    const MODEL = Occupation::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }
}
