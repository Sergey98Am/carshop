<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Models\Country;
use Validator;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:2|max:255',
            'last_name' => 'required|min:2|max:255|',
            'email' => 'required|string|email|max:255|unique:users',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'country_id' => 'exists:countries,id',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
    //   $validated = $request->validated();

      $user = User::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'country_id' => $request->country_id,
        'date_of_birth' => $request->date_of_birth,
        'gender' => $request->gender,
        'password' => Hash::make($request->password),
      ]);

      $token = JWTAuth::fromUser($user);

      return response()->json(['result' => $token]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token =  JWTAuth::attempt($credentials)) {
            return response()->json(['token' => $token]);
        }

        return response()->json(['error' => 'Unauthorized']);
    }

    // public function get_user_details(Request $request)
    // {
    // 	return JWTAuth::user();

    // }

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