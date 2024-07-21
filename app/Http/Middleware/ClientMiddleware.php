<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guard('client')->check()) {
            $response = $next($request);
            $response->headers->set('Permissions-Policy', 'geolocation=(self), microphone=(), camera=()');
            return $response;
        } else {
            return redirect('/client-login');
        }
    }
}
