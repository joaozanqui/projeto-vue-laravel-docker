<?php

namespace App\Services\Activities;

use App\Models\Activity;
class GetAllActivitiesService
{
    public function execute() 
    {
        return Activity::all()->toArray();
    }
}
