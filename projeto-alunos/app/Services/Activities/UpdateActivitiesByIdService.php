<?php

namespace App\Services\Activities;

use App\Models\Activity;

class UpdateActivitiesByIdService
{
    public function execute(int $id, array $data) 
    {
        $activity = Activity::find($id);
        throw_unless($activity, new \Exception('Atividade não localizada.', 422));
        $activity->update($data);
        
        return Activity::find($id)->toArray();
    }
}
