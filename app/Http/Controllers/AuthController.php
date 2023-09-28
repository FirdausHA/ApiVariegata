<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;

class AuthController extends Controller
{
    public function getAllUsers()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    public function register(Request $req)
    {
        // Validate
        $rules = [
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:6'
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Create new user in users table
        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password)
        ]);

        $token = $user->createToken('Personal Access Token')->plainTextToken;
        $response = ['user' => $user, 'token' => $token];
        return response()->json($response, 200);
    }

    public function login(Request $req)
    {
        // Validate inputs
        $rules = [
            'email' => 'required',
            'password' => 'required|string'
        ];
        $req->validate($rules);

        // Find user email in users table
        $user = User::where('email', $req->email)->first();

        // If user email found and password is correct
        if ($user && Hash::check($req->password, $user->password)) {
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response = ['user' => $user, 'token' => $token];
            return response()->json($response, 200);
        }

        $response = ['message' => 'Incorrect email or password'];
        return response()->json($response, 400);
    }

    public function logout(Request $request)
    {
        // Mengecek apakah pengguna sudah login
        if (Auth::check()) {
            // Menghapus access token saat ini dari database
            $request->user()->tokens->each(function ($token, $key) {
                $token->delete();
            });

            // Mengembalikan respons
            return response()->json(['message' => 'Logged out successfully'], 200);
        } else {
            // Jika pengguna belum login, Anda bisa memberikan respons kesalahan sesuai kebutuhan.
            return response()->json(['message' => 'User not logged in'], 401);
        }
    }

}
