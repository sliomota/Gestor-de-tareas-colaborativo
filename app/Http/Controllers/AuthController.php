<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function authenticate(Request $request): RedirectResponse

    {
        $credentials = $request->validate([

            'email' => ['required', 'email'],
            'password' => ['required'],

        ]);

 

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();
            
    $token = Auth::user()->createToken($request->email)->plainTextToken;
 
            return response()->json(["token"=>$token]);

        }

 

        return back()->withErrors([

            'email' => 'The provided credentials do not match our records.',

        ])->onlyInput('email');

    }

    public function deauthenticate(Request $request){
Auth::user()->tokens()->delete();
Auth::logout();
 

    $request->session()->invalidate();

    $request->session()->regenerateToken();
    return response()->json(["email"=>"Usuario desautenticado"]);
    }
}
