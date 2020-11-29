<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index() 
    {
        $users = UserResource::collection(User::paginate(10));

        return response()->json([
            'users' => $users
        ], Response::HTTP_OK);
    }

    public function store(UserRequest $request) 
    {
        User::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'User Successfully Added!'
        ], Response::HTTP_OK);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = $request->user_type;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User Successfully Updated'
        ], Response::HTTP_OK);
    }
}
