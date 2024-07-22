<?php

namespace App\Services;

use App\Models\Kyc;

class KycService extends ModelService
{
    const MODEL = Kyc::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }
}
