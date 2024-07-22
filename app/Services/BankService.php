<?php

namespace App\Services;

use App\Models\Bank;

class BankService extends ModelService
{
    const MODEL = Bank::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }
}
