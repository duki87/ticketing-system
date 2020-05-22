<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        if (!($request->user()->role() === $role)) {
            return redirect()->back();
        }
        return $next($request);
    }

}
