<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Futar
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->jogosultsag === 'futár') {
            return $next($request);
        }

        abort(401);
    }
}