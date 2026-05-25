<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarArea
{
    public function handle(Request $request, Closure $next, $areaPermitida)
    {
        $guard = 'web';
        
        if ($request->is('admin*')) {
            $guard = 'admin';
        } elseif ($request->is('industria*')) {
            $guard = 'industria';
        } elseif ($request->is('desarrollo*')) {
            $guard = 'desarrollo';
        } elseif ($request->is('proteccion*')) {
            $guard = 'proteccion';
        } elseif ($request->is('ingresos*')) {
            $guard = 'ingresos';
        }
        
        $user = Auth::guard($guard)->user();
        
        if ($user && $user->rol === 'Administrador general') {
            return $next($request);
        }
        
        if (!$user || $user->area_id != $areaPermitida) {
            abort(403, 'No tienes permiso para acceder a esta área.');
        }
        
        return $next($request);
    }
}