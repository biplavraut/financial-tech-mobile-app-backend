<?php

namespace App\Services;

use App\Models\Loan;

class LoanService extends ModelService
{
    const MODEL = Loan::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }
}
