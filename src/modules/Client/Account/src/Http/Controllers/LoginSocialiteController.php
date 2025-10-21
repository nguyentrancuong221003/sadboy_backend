<?php

namespace Modules\Client\Account\src\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\User\src\Models\User;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
class LoginSocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request) {
        try {
            $googleUser = Socialite::driver('google')->user();
            $email = $googleUser->getEmail();
            $name = $googleUser->getName();
            $code = Str::random(10);

            $user = User::where('email', $email)->first();

            if (!$user) {
                $passwordOriginal = Str::random(10);
                $user = User::create([
                    'code' => $code,
                    'email' => $email,
                    'name' => $name,
                    'password' => Hash::make($passwordOriginal),
                ]);

                $credentials = [
                    'email' => $email,
                    'password' => $passwordOriginal
                ];
            } else {
                $credentials = [
                    'email' => $email,
                    'password' => null
                ];
            }

            if ($credentials['password']) {
                $token = auth()->guard('user')->attempt($credentials);
            } else {
                $token = auth()->guard('user')->login($user);
            }

            if (!$token) {
                throw new \Exception('Unauthorized', 401);
            }

            $refreshToken = JWTAuth::customClaims([
                'type' => 'refresh_token'
            ])->fromUser($user);

            JWTAuth::factory()->setTTL(10080);
            $host = env('APP_URL');

            return redirect('http://localhost:5173')
            ->cookie('access_token', $token, 15, '/', null, false, true, 'None')
            ->cookie('refresh_token', $refreshToken, 10080, '/', null, false, true, 'None');

        }
        catch (\Exception $e) {
            Log::error('Lỗi callback Google: '.$e->getMessage().' - '.$e->getFile().':'.$e->getLine());
            return response()->json(['error' => $e->getMessage()], 500);
        }


    }

    public function login() {

    }
}
