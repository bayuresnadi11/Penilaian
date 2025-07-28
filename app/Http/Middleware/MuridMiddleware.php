<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MuridMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'murid') {
            return $next($request);
        }

        abort(403, 'Akses hanya untuk murid.');
    }
}
