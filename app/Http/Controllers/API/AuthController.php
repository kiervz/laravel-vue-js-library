<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->all();

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                $this->incrementLoginAttempts($request);
                return response()->json(['error' => 'Invalid Credentials'], 401);
            }
        }
        catch(JWTException $e) {
            // something went wrong
            $this->incrementLoginAttempts($request);
            return response()->json(['error' => 'Could Not Create Token'], 500);
        }

        return $this->respondWithToken($token);
    }

    public function register(RegisterRequest $request) 
    {   
        try {
            User::create($request->all());
        }
        catch(Exception $e) {
            if ($e->getCode() == 23000) {
                return response()->json(['error' => 'Email is already exist.'], 500);
            }
            
            return response()->json(['error' => 'Something went wrong.'], 500);
        }

        return response()->json([
            'message' => 'Successfully Registered.',
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => Auth::user()->name,
            // 'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}
