<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class NotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ( ! $request->user()->role->isAdmin()) {
            return $next($request);
        }

        return response()->json(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
    }
}
