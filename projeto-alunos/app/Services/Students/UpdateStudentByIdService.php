<?php

namespace App\Services\Students;

use App\Models\Student;

class UpdateStudentByIdService
{
    public function execute(int $id, array $data) 
    {
        $student = Student::find($id);
        throw_unless($student, new \Exception('Aluno não localizado.', 422));
        $student->update($data);
        
        return Student::find($id)->toArray();
    }
}
