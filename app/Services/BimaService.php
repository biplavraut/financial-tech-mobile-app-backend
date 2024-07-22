<?php

namespace App\Services;

use App\Models\Bima;

class BimaService extends ModelService
{
    const MODEL = Bima::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }
}
