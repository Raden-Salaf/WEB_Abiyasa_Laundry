<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventBackHistory
{
    // Middleware ini menambahkan header supaya browser tidak menyimpan cache halaman
    // yang butuh login, sehingga tombol "back" tidak menampilkan halaman lama setelah logout
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Header ini memerintahkan browser untuk selalu request ulang ke server,
        // bukan menampilkan versi cache/screenshot halaman sebelumnya
        $response->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');

        return $response;
    }
}