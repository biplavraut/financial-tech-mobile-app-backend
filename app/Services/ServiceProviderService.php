<?php

namespace App\Services;

use App\Models\ServiceProvider;

class ServiceProviderService extends ModelService
{
    const MODEL = ServiceProvider::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }
}
