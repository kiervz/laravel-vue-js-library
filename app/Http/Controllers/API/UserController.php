<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $status = 'success';
        $message = 'User Successfully Updated';

        if ($id == '1' && Auth::id() == '1') {
            $status = 'warning';
            $message = 'Cannot update your account';
        } else {
            $user = User::findOrFail($id);
    
            $user->name = $request->name;
            $user->email = $request->email;
            $user->user_type = $request->user_type;
            $user->save();
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $status = 'success';
        $message = 'User Successfully Deleted';

        if (Auth::id() == $id) {
            $status = 'warning';
            $message = 'Cannot delete your account';
        } else if ($id == '1') {
            $status = 'warning';
            $message = 'Cannot delete Super Admin';
        } else {
            $user = User::findOrFail($id);
            $user->delete();
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ], Response::HTTP_OK);
    }
}
