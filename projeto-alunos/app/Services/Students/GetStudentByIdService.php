<?php

namespace App\Services\Students;

use App\Models\Student;

class GetStudentByIdService
{
    public function execute(int $id) 
    {
        $student = Student::find($id);
        throw_unless($student, new \Exception('Aluno não localizado.', 422));

        return  Student::find($id)->toArray();
    }
}
