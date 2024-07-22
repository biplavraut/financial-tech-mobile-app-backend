<?php

namespace App\Services;

use App\Models\BankLoanType;

class LtypeService extends ModelService
{
    const MODEL = BankLoanType::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }
}
