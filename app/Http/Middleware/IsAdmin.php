<?php

namespace App\Http\Middleware;

use App\Http\Controllers\API\HomeController;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->user()->user_type != 'Administrator') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized!'
            ], 401);
        }
        return $next($request);
    }
}
