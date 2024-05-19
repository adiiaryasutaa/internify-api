<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\Contracts\RegistersUsers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\StoreUserRequest;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __invoke(RegistersUsers $registrar, StoreUserRequest $request): JsonResponse
    {
        $registrar->register($request->safe()->only(['name', 'username', 'email', 'password', 'role']));

        return response()->json([
            'message' => 'User successfully registered',
        ]);
    }
}
