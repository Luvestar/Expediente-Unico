<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarArea
{
    public function handle(Request $request, Closure $next, $areaPermitida)
    {
        $user = Auth::user();
        
        // Administrador general puede acceder a todo
        if ($user->hasRole('Administrador general')) {
            return $next($request);
        }
        
        // Verificar que el área del usuario coincida con el área permitida
        if ($user->area_id != $areaPermitida) {
            abort(403, 'No tienes permiso para acceder a esta área.');
        }
        
        return $next($request);
    }
}