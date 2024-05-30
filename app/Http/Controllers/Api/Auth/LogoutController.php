<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\Contracts\LogoutsUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class LogoutController extends Controller
{
    public function __invoke(LogoutsUsers $authenticator, Request $request): JsonResponse
    {
        $authenticator->logout($request->user());

        return response()->json(['message' => 'Logged out success, see you again']);
    }
}
