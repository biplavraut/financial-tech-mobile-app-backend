<?php

namespace App\Services;

use App\Models\Branch;

class BranchService extends ModelService
{
    const MODEL = Branch::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }
}
