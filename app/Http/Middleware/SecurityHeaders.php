<?php

namespace App\Http\Middleware;

use Closure;

class SecurityHeaders
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        
        // Prevenir clickjacking
        $response->headers->set('X-Frame-Options', 'DENY');
        
        // Prevenir MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        
        // Prevenir XSS
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // Controlar información de referer
        $response->headers->set('Referrer-Policy', 'same-origin');
        
        return $response;
    }
}