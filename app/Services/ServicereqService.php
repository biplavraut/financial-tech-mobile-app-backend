<?php

namespace App\Services;

use App\Models\Account;
use App\Models\ServiceRequest;

class ServicereqService extends ModelService
{
    const MODEL = ServiceRequest::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }
}
