<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() 
    {
        $users = UserResource::collection(User::paginate(10));

        return response()->json([
            'users' => $users
        ]);
    }

    public function store(UserRequest $request) 
    {
        User::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'User Successfully Added!'
        ]);
    }
}
