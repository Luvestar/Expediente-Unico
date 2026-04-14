<?php

namespace App\Http\Middleware;

use Closure;

class SanitizeInput
{
    public function handle($request, Closure $next)
    {
        // Solo para métodos POST y PUT
        if ($request->isMethod('post') || $request->isMethod('put')) {
            $input = $request->all();
            
            array_walk_recursive($input, function (&$value) {
                if (is_string($value)) {
                    // Eliminar etiquetas HTML
                    $value = strip_tags($value);
                    // Eliminar espacios al inicio y final
                    $value = trim($value);
                    // Convertir caracteres especiales a entidades HTML
                    $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                }
            });
            
            $request->merge($input);
        }
        
        return $next($request);
    }
}