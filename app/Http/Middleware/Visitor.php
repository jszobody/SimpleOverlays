<?php

namespace App\Http\Middleware;

use App\User;
use Auth;
use Closure;
use Illuminate\Http\Request;

class Visitor
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check()) {
            $request->setUserResolver(function () {
                return User::whereEmail('visitor')->whereName('Visitor')->first();
            });
        }

        return $next($request);
    }
}
