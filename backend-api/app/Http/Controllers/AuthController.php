<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('login', 'password');

        if ($credentials['login'] === 'admin' && $credentials['password'] === 'admin') {

            $user = User::firstOrCreate(
                ['email' => 'admin@example.com'],
                ['name' => 'Admin', 'password' => bcrypt('admin')]
            );

            $token = $user->createToken('AdminToken')->plainTextToken;

            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
