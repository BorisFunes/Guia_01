<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users,email',
            'password'   => 'required|string|min:8|confirmed',
        ]);

        $user = User::create($data);

        $token = $this->guard()->login($user);

        return $this->respondWithToken($token, 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $token = $this->guard()->attempt($credentials);

        if ($token === false) {
            return response()->json([
                'message' => 'Credenciales inválidas.',
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json($this->guard()->user());
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    public function logout()
    {
        $this->guard()->logout();

        return response()->json([
            'message' => 'Sesión cerrada correctamente.',
        ]);
    }

    private function respondWithToken(string $token, int $status = 200)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $this->guard()->getTTL() * 60,
            'user'         => $this->guard()->user(),
        ], $status);
    }

    private function guard(): JWTGuard
    {
        return Auth::guard('api');
    }
}
