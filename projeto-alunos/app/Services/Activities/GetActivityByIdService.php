<?php

namespace App\Services\Activities;

use App\Models\Activity;

class GetActivityByIdService
{
    public function execute(int $id) 
    {
        $activity = Activity::find($id);
        throw_unless($activity, new \Exception('Atividade não localizada.', 422));

        return  Activity::find($id)->toArray();
    }
}
