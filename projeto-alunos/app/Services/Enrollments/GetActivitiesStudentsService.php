<?php

namespace App\Services\Enrollments;

use App\Models\Activity;

class GetActivitiesStudentsService
{
    public function execute(int $activity_id)
    {
        $activity = Activity::find($activity_id);
        throw_unless($activity, new \Exception('Atividade não localizada.', 422));

        return $activity->students;
    }
}
