<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsSantri
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->role !== 'santri') {
            abort(403, 'Akses ditolak. Fitur ini khusus untuk peran Santri.');
        }

        return $next($request);
    }
}
