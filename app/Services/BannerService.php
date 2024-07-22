<?php

namespace App\Services;

use App\Models\Banner;

class BannerService extends ModelService
{
    const MODEL = Banner::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }
}
