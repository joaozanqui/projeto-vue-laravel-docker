<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Services\Enrollments\StoreStudentActivityService;
use App\Services\Enrollments\DeleteStudentActivityService;
use App\Services\Enrollments\GetStudentsActivitiesService;
use App\Services\Enrollments\GetActivitiesStudentsService;

class EnrollmentController extends Controller
{
    private $store_student_activity_service;
    private $delete_student_activity_service;
    private $get_students_activities_service;
    private $get_activities_students_service;

    public function __construct(
        StoreStudentActivityService $store_student_activity_service,
        DeleteStudentActivityService $delete_student_activity_service,
        GetStudentsActivitiesService $get_students_activities_service,
        GetActivitiesStudentsService $get_activities_students_service
    ) {
        $this->store_student_activity_service = $store_student_activity_service;
        $this->delete_student_activity_service = $delete_student_activity_service;
        $this->get_students_activities_service = $get_students_activities_service;
        $this->get_activities_students_service = $get_activities_students_service;
    }

    public function showStudentsActivities($student_id)
    {
        try {
            $activities = $this->get_students_activities_service->execute($student_id);

            return response()->json($activities, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function showActivitiesStudents($activity_id)
    {
        try {
            $students = $this->get_activities_students_service->execute($activity_id);

            return response()->json($students, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function store($student_id, $activity_id)
    {
        try {
            $this->store_student_activity_service->execute($student_id, $activity_id);

            return response()->json(['status' => true], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($student_id, $activity_id)
    {
        try {
            $this->delete_student_activity_service->execute($student_id, $activity_id);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }


}
