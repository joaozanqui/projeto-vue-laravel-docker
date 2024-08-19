<?php

namespace App\Services\Students;

use App\Models\Student;

class GetAllStudentsService
{
    public function execute() 
    {
        return Student::all()->toArray();
    }
}
