<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            auth()->logout(); // Log out the user
            return redirect()->back()->withErrors(['email' => 'Unauthorized access.']);
        }

        return $next($request);
    }
}
