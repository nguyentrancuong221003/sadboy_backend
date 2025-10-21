<?php

namespace Modules\Admin\Employee\src\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Tymon\JWTAuth\Facades\JWTAuth;
use Modules\Admin\Employee\src\Http\Requests\LoginRequest;
class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');

        if (! $token = auth()->guard('employee')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $employee=auth()->guard('employee')->user();
        $refreshToken = JWTAuth::customClaims([
            'type' => 'refresh_token'
        ])->fromUser($employee);

        JWTAuth::factory()->setTTL(10080);

        return response()->json([
            'message' => 'Đăng nhập thành công',
            'data' => [
                'name' => $employee->name,
                'phone' => $employee->phone,
                'email' => $employee->email,
                'img' => env('APP_URL').$employee->img
            ]
        ], 200)->cookie(
            'access_token', $token, 15, '/', null, false, true
        )->cookie(
            'refresh_token', $refreshToken, 10080, '/', null, false, true
        );
    }


    public function refresh(Request $request)
    {
        try {
            $refreshToken = $request->cookie('refresh_token');
            if (!$refreshToken) {
                return response()->json(['error' => 'Refresh token not found'], 404);
            }
            $jwt = auth('employee');
            $jwt->setToken($refreshToken);
            $payload = $jwt->getPayload();
            if ($payload->get('type') !== 'refresh_token') {
                return response()->json(['error' => 'Invalid token type'], 401);
            }
            $user = $jwt->authenticate(); // dùng authenticate() thay vì toUser()
            if (!$user) {
                return response()->json(['error' => 'employee not found'], 401);
            }
            $newToken = $jwt->fromUser($user);

            return response()->json(['message' => 'Token refreshed successfully'])
                ->cookie('access_token', $newToken, 15, '/', null, false, true);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Refresh token expired'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $jwt = auth('employee'); // dùng guard employee
            $jwt->invalidate($jwt->getToken());

            return response()->json([
                'status' => 'success',
                'message' => 'Đăng xuất thành công'
            ])
            ->cookie('access_token', '', -1, '/', null, false, true)
            ->cookie('refresh_token', '', -1, '/', null, false, true);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Logout failed'], 500);
        }
    }


    public function me()
    {
        $employee = auth('employee')->user();
        $host = env('APP_URL');
        if (empty($employee)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Lấy thông tin đăng nhập thành công',
                'data' => [
                    'code' => $employee->code,
                    'name' => $employee->name,
                    'email' => $employee->email,
                    'img' => $host.$employee->img,
                    'phone' => $employee->phone
                ]
            ],
        200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

}
