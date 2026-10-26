<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user belum login, atau role-nya BUKAN admin, tolak aksesnya!
        if (!in_array($request->user()->role, ['owner', 'admin'])) {
            abort(403, 'AKSES DITOLAK: Hanya Admin / Owner yang diizinkan untuk mengubah data master ini.');
        }

        return $next($request);
    }
}