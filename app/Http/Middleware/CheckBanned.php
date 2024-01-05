<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check() && (auth()->user()->status == 'Banned')){
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken(); 

            return redirect()->route('login')->with('Failed', 'Akun Anda dibanned, Silahkan hubungi Super admin.');
        }
        return $next($request);

    }
}
