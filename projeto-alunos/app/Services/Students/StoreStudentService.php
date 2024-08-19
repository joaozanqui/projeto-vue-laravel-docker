<?php

namespace App\Services\Students;

use App\Models\Student;

class StoreStudentService
{
    public function execute(array $data) 
    {
        return Student::create($data)->toArray();
    }
}
