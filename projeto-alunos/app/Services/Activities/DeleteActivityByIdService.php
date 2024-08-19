<?php

namespace App\Services\Activities;

use App\Models\Activity;

class DeleteActivityByIdService
{
    public function execute(int $id) 
    {
        $activities = Activity::find($id);
        throw_unless($activities, new \Exception('Atividade não localizada.', 422));

        return  $activities->delete();
    }
}
