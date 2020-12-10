<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index() 
    {
        $users = User::paginate(10);

        return response()->json([
            'users' => UserResource::collection($users)->response()->getData(true)
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

    public function changePassword(Request $request) 
    {
        $this->validate($request, [
            'password' => ['required', new MatchOldPassword],
            'new_password' => 'required|string|max:25',
            'confirm_new_password' => 'required|string|max:25|same:new_password'
        ]);

        $status = "success";
        $message = "Password Successfully Updated!";
        if (!Hash::check($request->password, Auth::user()->password)) {
            $status = "error";
            $message = "Password Unsuccessfully Updated!";
        } else {
            $user = User::find(Auth::id());
            $user->password = $request->new_password;
            $user->update();
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

}
