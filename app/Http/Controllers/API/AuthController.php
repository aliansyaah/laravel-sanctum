<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // print_r($request->email);
        // dd($request->all());

        // Cek email yg diinput user dgn DB
        $user = User::where('email', $request->email)->first();

        // Jika user tdk ditemukan atau password tidak sesuai
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                // 'message' => 'Password tidak sesuai.'
                'message' => 'Unauthorized.'
            ], 401);
        }

        $token = $user->createToken('token-name')->plainTextToken;
        return response()->json([
            'message' => 'success',
            'user' => $user,
            'token' => $token
        ], 200);
    }
}
