<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (
            $user &&
            $user->role->nama === 'bk' &&
            $user->must_change_password === true &&
            !$request->routeIs('bk.password.*') &&
            !$request->routeIs('logout')
        ) {
            return redirect()->route('bk.password.index')
                             ->with('warning', 'Anda wajib mengganti password terlebih dahulu.');
        }

        return $next($request);
    }
}