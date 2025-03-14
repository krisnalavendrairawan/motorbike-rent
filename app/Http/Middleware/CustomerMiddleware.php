<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('customer.login.index');
        }

        if (!Auth::user()->hasRole('customer')) {
            Auth::logout();
            return redirect()->route('customer.login.index')
                ->withErrors(['email' => 'Halaman ini hanya untuk customer.'])
                ->with('sweetalert', true);
        }

        return $next($request);
    }
}
