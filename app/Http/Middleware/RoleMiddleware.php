<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Cek apakah slug role user ada dalam parameter yang diizinkan
        // Kita asumsikan relasi role() sudah ada di model User
        if (in_array($user->role->slug, $roles)) {
            return $next($request);
        }

        // 3. Jika tidak punya akses, lempar ke halaman yang sesuai role-nya
        return match ($user->role->slug) {
            'admin'     => redirect()->route('admin.dashboard'),
            'organizer' => redirect()->route('organizer.dashboard'),
            'checker'   => redirect()->route('checker.dashboard'),
            default     => redirect()->route('home')->with('error', 'Akses Ditolak.'),
        };
    }
}
