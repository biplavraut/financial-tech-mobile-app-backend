<?php

namespace App\Services;

use App\Models\Address;

class AddressService extends ModelService
{
    const MODEL = Address::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }
}
