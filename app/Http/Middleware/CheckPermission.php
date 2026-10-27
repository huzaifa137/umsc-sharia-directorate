<?php

namespace App\Http\Middleware;

use App\Services\AccessControl;
use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    /**
     * Usage in routes: ->middleware('permission:users.create')
     * Multiple slugs separated by "|" are treated as OR (any one is enough).
     */
    public function handle(Request $request, Closure $next, string $slugs)
    {
        $allowed = collect(explode('|', $slugs))->contains(fn ($slug) => AccessControl::can(trim($slug)));

        if (!$allowed) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status' => false,
                    'message' => 'You do not have permission to perform this action.',
                ], 403);
            }

            return response()->view('errors.403', [], 403);
        }

        return $next($request);
    }
}
