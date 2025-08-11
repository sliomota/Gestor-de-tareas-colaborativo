<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/auth/login",
     *     summary="Autenticar usuario y generar token",
     *     tags={"Autenticación"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="12345678")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="1|qwertyuiopasdfghjklzxcvbnm123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales incorrectas"
     *     )
     * )
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(["email" => "Credenciales incorrectas"], 401);
        }

        $token = Auth::user()->createToken($request->email)->plainTextToken;
        return response()->json(["token" => $token]);
    }

    /**
     * @OA\Post(
     *     path="/auth/logout",
     *     summary="Cerrar sesión y revocar token",
     *     tags={"Autenticación"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Usuario desautenticado",
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="Usuario desautenticado")
     *         )
     *     )
     * )
     */
    public function deauthenticate(Request $request)
    {
        Auth::user()->tokens()->delete();
        return response()->json(["email" => "Usuario desautenticado"]);
    }

    /**
     * @OA\Post(
     *     path="/auth/register",
     *     summary="Registrar un nuevo usuario",
     *     tags={"Autenticación"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password","password_confirmation"},
     *             @OA\Property(property="name", type="string", example="Juan Pérez"),
     *             @OA\Property(property="email", type="string", format="email", example="juan@example.com"),
     *             @OA\Property(property="password", type="string", example="12345678"),
     *             @OA\Property(property="password_confirmation", type="string", example="12345678")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario registrado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Juan Pérez"),
     *                 @OA\Property(property="email", type="string", example="juan@example.com"),
     *                 @OA\Property(property="created_at", type="string", example="2025-08-11T08:00:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", example="2025-08-11T08:00:00.000000Z")
     *             ),
     *             @OA\Property(property="token", type="string", example="1|asdfghjkl1234567890qwertyuiop")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos inválidos"
     *     )
     * )
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:80',
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:8'
        ]);

        $validated["password"] = Hash::make($validated['password']);

        $user = User::create($validated);
        $token = $user->createToken($validated['email'])->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    }
}
