<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function authenticate(Request $request)

    {
        $credentials = $request->validate([

            'email' => ['required', 'email'],
            'password' => ['required'],

        ]);



        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $token = Auth::user()->createToken($request->email)->plainTextToken;

            return response()->json(["token" => $token]);
        }



        return back()->withErrors([

            'email' => 'The provided credentials do not match our records.',

        ])->onlyInput('email');
    }

    public function deauthenticate(Request $request)
    {
        Auth::user()->tokens()->delete();
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return response()->json(["email" => "Usuario desautenticado"]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:80',
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:8'
        ]);

        $validated["password"] = Hash::make($validated['password']);

        $user = User::create($validated);
        auth()->login($user);
        $token = $user->createToken($validated['email'])->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    }
}
