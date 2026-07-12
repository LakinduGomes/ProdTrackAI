<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMenuAccess
{

    public function handle($request, Closure $next)
    {
        if (!auth()->user() || !auth()->user()->hasPermission('view-menu')) {
            return redirect('/');
        }
        return $next($request);
    }

}
