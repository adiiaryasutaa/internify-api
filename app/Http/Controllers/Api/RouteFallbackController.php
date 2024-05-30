<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class RouteFallbackController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json([
            'message' => 'Route not found. If error persists, please contact us at adiaryasuta.dev@gmail.com.',
        ], 404);
    }
}
