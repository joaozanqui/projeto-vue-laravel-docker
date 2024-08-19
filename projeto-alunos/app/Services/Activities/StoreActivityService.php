<?php

namespace App\Services\Activities;

use App\Models\Activity;

class StoreActivityService
{
    public function execute(array $data) 
    {
        return Activity::create($data)->toArray();
    }
}
