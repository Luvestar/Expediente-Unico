<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandleTokenFromUrl
{
    public function handle(Request $request, Closure $next)
    {
        // Si no hay header Authorization pero sí hay un token en la URL
        if (!$request->bearerToken() && $request->has('token')) {
            $request->headers->set('Authorization', 'Bearer ' . $request->query('token'));
        }

        $response = $next($request);

        // Si es una redirección y tenemos un token en la petición, lo adjuntamos a la URL de destino
        if ($response instanceof \Illuminate\Http\RedirectResponse && $request->has('token')) {
            $targetUrl = $response->getTargetUrl();
            $token = $request->query('token');
            
            $separator = str_contains($targetUrl, '?') ? '&' : '?';
            $response->setTargetUrl($targetUrl . $separator . 'token=' . $token);
        }

        return $response;
    }
}