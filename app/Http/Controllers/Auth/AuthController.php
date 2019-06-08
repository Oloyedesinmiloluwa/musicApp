<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login()
    {

        $this->validate(
            request(),
            [
                'user.email' => ['required', 'email'],
                'user.password' => ['required'],
            ]
        );
        try {
            $user = request()->input('user');
            $credentials = [
                'email' => $user['email'],
                'password' => $user['password']
            ];
            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['message' => 'Username or password is invalid'], 401);
            }
            return $this->respondWithToken($token);
        } catch (JWTException $e) {
            return response()->json(['message' => 'An error occured', 'error' => $e]);
        }
    }

    public function logout()
    {
        auth()->logout();
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'message' => 'Login successful',
            'data' => request()->only('user'),
            'access_token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
