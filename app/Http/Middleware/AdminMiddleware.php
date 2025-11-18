<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', '⚠️ Silakan login terlebih dahulu');
        }

        // ✅ Cek is_admin (bukan role)
        if (!auth()->user()->is_admin) {
            abort(403, '🚫 Unauthorized - Admin access only');
        }

        return $next($request);
    }
}