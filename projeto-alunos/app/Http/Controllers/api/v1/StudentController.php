<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Requests\CreateStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Services\Students\StoreStudentService;
use App\Services\Students\GetAllStudentsService;
use App\Services\Students\UpdateStudentByIdService;
use App\Services\Students\GetStudentByIdService;
use App\Services\Students\DeleteStudentByIdService;

class StudentController extends Controller
{
    private $get_all_students_service;
    private $store_sudent_service;
    private $update_student_by_id_service;
    private $get_student_by_id_service;
    private $delete_student_by_id_service;
    
    public function __construct (
        GetAllStudentsService $get_all_students_service,
        StoreStudentService $store_sudent_service,
        UpdateStudentByIdService $update_student_by_id_service,
        GetStudentByIdService $get_student_by_id_service,
        DeleteStudentByIdService $delete_student_by_id_service)
    {
        $this->get_all_students_service = $get_all_students_service;
        $this->store_sudent_service = $store_sudent_service;
        $this->update_student_by_id_service = $update_student_by_id_service;
        $this->get_student_by_id_service = $get_student_by_id_service;
        $this->delete_student_by_id_service = $delete_student_by_id_service;
    }

    public function index()
    {
        try {
            $students = $this->get_all_students_service->execute();

            return response()->json([$students], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(CreateStudentRequest $request)
    {
        try {
            $data = [
                'name' => $request->input('name'),
                'ra' => $request->input('ra'),
                'email' => $request->input('email')
            ];

            $student = $this->store_sudent_service->execute($data);

            return response()->json([$student], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $student = $this->get_student_by_id_service->execute($id);  

            return response()->json([$student], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }

    }

    public function update(UpdateStudentRequest $request, $id)
    {
        try {
            $data = $request->all();
            $student = $this->update_student_by_id_service->execute($id, $data);

            return response()->json([$student], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $res = $this->delete_student_by_id_service->execute($id);

            return response()->json(['status' => $res], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }
}
