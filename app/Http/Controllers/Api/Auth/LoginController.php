<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\Contracts\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\AuthenticateUserRequest;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __invoke(AuthenticatesUsers $authenticator, AuthenticateUserRequest $request): JsonResponse
    {
        $credentials = $request->safe()->only(['email', 'password']);

        $response = $authenticator->authenticate($credentials);

        if (! $response) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'message' => 'Login success, welcome',
            ...$response,
        ]);
    }
}
