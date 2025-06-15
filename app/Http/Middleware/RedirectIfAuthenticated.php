<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'guru') {
                return redirect('/dashboard/guru');
            } elseif ($user->role === 'siswa') {
                return redirect('/dashboard/siswa');
            } elseif ($user->role === 'orang_tua') {
                return redirect('/dashboard/orangtua');
            } elseif ($user->role === 'petugas') {
                return redirect('/dashboard/petugas');
            } else {
                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}