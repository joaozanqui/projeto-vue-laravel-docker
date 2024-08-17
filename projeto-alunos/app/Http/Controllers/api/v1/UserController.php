<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrUpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class UserController extends Controller
{


    /**
     * 
     * @return JsonResponse
     */

    public function index()
    {
        try {
            $users = User::all();

            return response()->json(['status' => true, 'users' => $users], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * 
     * @param CreateOrUpdateUserRequest $request
     * @return JsonResponse
     */

    public function store(CreateOrUpdateUserRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password'))
            ]);

            return response()->json(['status' => true, 'users' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * 
     * @param int $id
     * @return Response
     */
    public function show(string $id)
    {
        try {
            $user = User::find($id);

            return response()->json(['status' => true, 'users' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * 
     * @param CreateOrUpdateUserRequest $request
     * @param int $id
     * @return Response
     */
    public function update(CreateOrUpdateUserRequest $request, string $id)
    {
        try {
            $data = $request->all();
            $user = User::find($id);
            $user->update($data);

            return response()->json(['status' => true, 'users' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * 
     * @param int $id
     * @return Response
     */
    public function destroy(string $id)
    {
        try {
            $user = User::find($id);
            $user->delete();

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
}
