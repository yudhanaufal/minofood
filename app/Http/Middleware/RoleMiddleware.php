<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    // PERHATIKAN BARIS INI: Harus ada ...$roles
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika user belum login atau role-nya tidak ada dalam daftar yang diizinkan
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}