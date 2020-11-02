<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\Country;
use Illuminate\Support\Facades\Hash;
use JWTAuth;

class AuthController extends Controller
{
    public function checkToken() {
        try {
            return response()->json([
                'success' => true,
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'country_id' => $request->country_id,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'password' => Hash::make($request->password),
            ]);

            if ($user) {
                $token = JWTAuth::fromUser($user);

                if ($request->rememberMe) {
                    $token = auth()->setTTL(86400 * 30)->fromUser($user);
                }

                return response()->json([
                    'token' => $token,
                    'user' => $user,
                    'ttl' => auth()->factory()->getTTL(),
                ], 200);
            } else {
                throw new \Exception('Something went wrong');
            }
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            $token = JWTAuth::attempt($credentials);

            if ($request->rememberMe) {
                $token = auth()->setTTL(86400 * 30)->attempt($credentials);
            }

            if ($token) {
                return response()->json([
                    'token' => $token,
                    'user' => JWTAuth::user(),
                ], 200);
            } else {
                throw new \Exception('Unauthorized');
            }
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate();

            return response()->json([
                'message' => 'Successfully logged out'
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function profile() {
        return response()->json([
            'user' => JWTAuth::user()->with('country')->first()
        ]);
    }

    public function countries() {
        return response()->json([
            'countries' => Country::all()
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL(),
        ]);
    }
}
