<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\Contracts\LogoutsUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke(LogoutsUsers $authenticator, Request $request): JsonResponse
    {
        $authenticator->logout($request->user());

        return response()->json(['message' => 'Logged out success, see you again']);
    }
}
