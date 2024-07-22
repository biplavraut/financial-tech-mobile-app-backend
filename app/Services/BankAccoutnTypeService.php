<?php

namespace App\Services;

use App\Models\BankAccountType;

class BankAccountTypeService extends ModelService
{
    const MODEL = BankAccountType::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }
}
