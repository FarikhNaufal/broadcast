<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $credentials = ['name' => $request->username, 'password' => $request->password];

        if (Auth::guard('client')->attempt($credentials)) {
            $user = Auth::guard('client')->user();
            $token = $user->createToken('AppName')->accessToken;
            return response()->json(['token' => $token, 'user_id' => $user->id], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
