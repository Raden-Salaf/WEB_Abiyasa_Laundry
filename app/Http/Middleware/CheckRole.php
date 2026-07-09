<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    // Middleware menerima parameter $roles, contoh: 'Administrator' atau 'Operator,Pimpinan'
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika belum login, lempar ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userLevel = Auth::user()->load('level')->level->level_name;

        // Jika level user tidak termasuk dalam daftar role yang diizinkan, tolak akses
        if (!in_array($userLevel, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}