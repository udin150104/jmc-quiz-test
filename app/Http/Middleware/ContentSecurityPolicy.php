<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // ✅ CSP untuk Laravel + Vite (dev & prod)
        $policy = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' http://localhost:5173",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
            "img-src 'self' data:",
            "font-src https://fonts.gstatic.com",
            "connect-src 'self' ws://localhost:5173 http://localhost:5173",
            "frame-ancestors 'none'",
            "base-uri 'self'"
        ];

        // Jika di production, hilangkan unsafe-inline / localhost
        if (app()->environment('production')) {
            $policy = [
                "default-src 'self'",
                "script-src 'self'",
                "style-src 'self' https://fonts.googleapis.com",
                "img-src 'self' data:",
                "font-src https://fonts.gstatic.com",
                "connect-src 'self'",
                "frame-ancestors 'none'",
                "base-uri 'self'"
            ];
        }

        $cspHeader = implode('; ', $policy);
        $response->headers->set('Content-Security-Policy', $cspHeader);

        return $next($request);
    }
}
