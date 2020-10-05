<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use App\Models\Country;
use JWTAuth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
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
          return response()->json([
              'token' => $token
          ],200);
      } else {
          return response()->json([
              'error' => 'Something went wrong'
          ],400);
      }
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token =  JWTAuth::attempt($credentials)) {
            return response()->json(['token' => $token]);
        } else {
            return response()->json(['error' => 'Unauthorized'],400);
        }
    }

    public function logout()
    {
        JWTAuth::invalidate();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }
}
