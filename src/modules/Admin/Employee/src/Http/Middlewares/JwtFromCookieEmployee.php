<?php

namespace Modules\Admin\Employee\src\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtFromCookieEmployee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        auth()->shouldUse('employee');
        $token = $request->cookie('access_token'); // lấy từ cookie

        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized: Token not found'], 401);
        }

        try {
            // Sử dụng guard 'employee' để authenticate token
            $employee = auth()->guard('employee')->setToken($token)->user();

            if (!$employee) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Unauthorized: Employee not found'
                ], 401);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized: Token expired'
            ], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized: Token invalid'
            ], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized: Token error'
            ], 401);
        }
        return $next($request);
    }
}
