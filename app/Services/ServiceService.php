<?php

namespace App\Services;

use App\Models\Service;

class ServiceService extends ModelService
{
    const MODEL = Service::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }
}
