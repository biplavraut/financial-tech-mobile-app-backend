<?php

namespace App\Services;

use App\Models\BimaAccount;

class BimaAccountService extends ModelService
{
    const MODEL = BimaAccount::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }
}
