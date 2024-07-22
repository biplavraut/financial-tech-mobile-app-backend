<?php

namespace App\Services;

use App\Models\Account;

class AccountService extends ModelService
{
    const MODEL = Account::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }
}
