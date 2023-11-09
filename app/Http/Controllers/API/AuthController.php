<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $this->validateLogin($request);
        if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
        }
        return response()->json([
        'token' => $request->user()->createToken($request->device)->plainTextToken,
        'message' => 'Success'
        ]);
    }
    public function validateLogin(Request $request)
    {
        return $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device' => 'required'
        ]);
    }
}