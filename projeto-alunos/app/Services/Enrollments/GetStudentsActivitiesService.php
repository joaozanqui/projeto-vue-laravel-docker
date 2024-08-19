<?php

namespace App\Services\Enrollments;

use App\Models\Student;

class GetStudentsActivitiesService
{
    public function execute(int $student_id)
    {
        $student = Student::find($student_id);
        throw_unless($student, new \Exception('Aluno não localizado.', 422));

        return $student->activities;
    }
}
