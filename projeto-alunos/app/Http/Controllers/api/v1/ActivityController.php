<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Services\Activities\GetActivityByIdService;
use App\Services\Activities\StoreActivityService;
use App\Services\Activities\UpdateActivitiesByIdService;
use App\Services\Activities\GetAllActivitiesService;
use App\Services\Activities\DeleteActivityByIdService;

class ActivityController extends Controller
{

    private $get_all_activities_service;
    private $store_activity_service;
    private $get_activity_by_id_service;
    private $update_activity_by_id_service;
    private $delete_activity_by_id_service;

    public function __construct(
        GetAllActivitiesService $get_all_activities_service,
        StoreActivityService $store_activity_service,
        GetActivityByIdService $get_activity_by_id_service,
        UpdateActivitiesByIdService $update_activity_by_id_service,
        DeleteActivityByIdService $delete_activity_by_id_service)
    {
        $this->get_all_activities_service = $get_all_activities_service;
        $this->store_activity_service = $store_activity_service;
        $this->get_activity_by_id_service = $get_activity_by_id_service;
        $this->update_activity_by_id_service = $update_activity_by_id_service;
        $this->delete_activity_by_id_service = $delete_activity_by_id_service;
    }

    public function index()
    {
        try {
            $activity = $this->get_all_activities_service->execute();

            return response()->json([$activity], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(CreateActivityRequest $request)
    {
        try {
            $data = [
                'name' => $request->input('name'),
                'description' => $request->input('description')
            ];

            $activity = $this->store_activity_service->execute($data);

            return response()->json([$activity], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $activity = $this->get_activity_by_id_service->execute($id);  

            return response()->json([$activity], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }

    }

    public function update(UpdateActivityRequest $request, $id)
    {
        try {
            $data = $request->all();
            $activity = $this->update_activity_by_id_service->execute($id, $data);

            return response()->json([$activity], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $res = $this->delete_activity_by_id_service->execute($id);

            return response()->json(['status' => $res], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }
}