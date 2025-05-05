<?php

// app/Http/Middleware/EnsureUserIsAdmin.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $userRole = $user->userRoles()->first();

        if (!$user || $userRole->role_id != 1) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}

