<?php

namespace App\Services;

use App\Models\Document;

class DocumentService extends ModelService
{
    const MODEL = Document::class;

    public function getForIndex($limit = 20, $columns = ['*'])
    {
        return $this->query()->latest()->paginate($limit, $columns);
    }
}
