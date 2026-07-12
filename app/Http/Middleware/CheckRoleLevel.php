<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoleLevel
{
    public function handle(Request $request, Closure $next, ...$levels)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userLevel = Auth::user()->level;

        if (in_array($userLevel, array_map('intval', $levels))) {
            return $next($request);
        }

        abort(403, 'Unauthorized.');
    }
}