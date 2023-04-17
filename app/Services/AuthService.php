<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signIn(object $request): object
    {
        $user = $this->user->whereUsername($request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'messages' => [
                    [__('auth.name_does_not_exists')]
                ]
            ], 403);
        }

        $token = auth('api')->attempt(
            $request->only([
                'username',
                'password'
            ])
        );

        if (!$token) {
            return response()->json([
                'success' => false,
                'messages' => [
                    [__('auth.login_failed')]
                ]
            ], 401);
        }

        return $this->respondWithToken($token, $request->remember_me);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signOut(): object
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token): object
    {
        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 90000000,
            'user' => auth()->user()
        ]);
    }
}
