<?php

namespace Modules\Client\Account\src\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Tymon\JWTAuth\Facades\JWTAuth;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');


            if (! $token = auth()->guard('user')->attempt($credentials)) {
                throw new \Exception('Unauthorized', 401);
            }
           
            $user=auth()->guard('user')->user();

            $refreshToken = JWTAuth::customClaims([
                'type' => 'refresh_token'
            ])->fromUser($user);

            JWTAuth::factory()->setTTL(10080);
            $host = env('APP_URL');
            return response()->json([
                'message' => 'Đăng nhập thành công',
                'data' => [
                    'name' => $user->name,
                    'img' => $host.$user->img,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'gender' => $user->gender,
                    'date_birth' => $user->date_birth
                ]
            ], 200)->cookie(
                'access_token', $token, 15, '/', null, false, true
            )->cookie(
                'refresh_token', $refreshToken, 10080, '/', null, false, true
            );
        }
        catch(\Exception $e) {
            Log::error('Người dùng đăng nhập thất bại ở authController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 401);
        }

    }


    public function refresh(Request $request)
    {
        try {
            $refreshToken = $request->cookie('refresh_token');

            if (!$refreshToken) {
                return response()->json(['error' => 'Refresh token not found'], 404);
            }

            // Set token trước
            JWTAuth::setToken($refreshToken);

            // Lấy payload để kiểm tra claim
            $payload = JWTAuth::getPayload();

            // Kiểm tra claim "type"
            if ($payload->get('type') !== 'refresh_token') {
                return response()->json(['error' => 'Invalid token type'], 401);
            }

            // Lấy user từ token
            $user = JWTAuth::toUser($refreshToken);

            if (!$user) {
                return response()->json(['error' => 'User not found'], 401);
            }

            // Tạo lại access token mới (TTL mặc định)
            $newToken = JWTAuth::fromUser($user);

            return response()->json(['message' => 'Token refreshed successfully'])->cookie(
                'access_token', $newToken, 15, '/', null, false, true
            );
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
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json(['message' => 'Đăng xuất thành công'])
                ->cookie('access_token', '', -1, '/', null, false, true)
                ->cookie('refresh_token', '', -1, '/', null, false, true);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Logout failed'], 500);
        }
    }

    public function me()
    {
        try {
            $user=auth()->guard('user')->user();
            $host = env('APP_URL');
            if (empty($user)) {
                throw new \Exception('Unauthorized', 401);
            }
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Lấy thông tin đăng nhập thành công',
                    'data' => [
                        'name' => $user->name,
                        'img' => $host.$user->img,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'gender' => $user->gender,
                        'date_birth' => $user->date_birth
                    ]
                ],
            200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch(\Exception $e) {
            Log::error('Người dùng đăng nhập thất bại ở authController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 401);
        }
    }

}
