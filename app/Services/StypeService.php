<?php

namespace App\Services;

use App\Models\BankServiceType;

class StypeService extends ModelService
{
    const MODEL = BankServiceType::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }
}
