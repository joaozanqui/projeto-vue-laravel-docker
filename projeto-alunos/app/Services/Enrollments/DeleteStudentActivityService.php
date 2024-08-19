<?php

namespace App\Services\Enrollments;

use App\Models\Student;
use App\Models\Activity;

class DeleteStudentActivityService
{
    public function execute(int $student_id, int $activity_id)
    {
        $student = Student::find($student_id);
        throw_unless($student, new \Exception('Aluno não localizado.', 422));

        $activity = Activity::find($activity_id);
        throw_unless($activity, new \Exception('Atividade não localizada.', 422));

        $student->activities()->detach($activity_id);
    }
}

