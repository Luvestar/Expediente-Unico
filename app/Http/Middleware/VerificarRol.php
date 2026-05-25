<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarRol
{
    public function handle(Request $request, Closure $next, ...$roles)
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
        
        if (!$user) {
            return redirect()->route('login', ['guard' => $guard]);
        }
        
        // Administrador general puede acceder a todo
        if ($user->rol === 'Administrador general') {
            return $next($request);
        }
        
        if (empty($roles)) {
            return $next($request);
        }
        
        foreach ($roles as $rol) {
            if ($user->rol === $rol) {
                return $next($request);
            }
        }

        abort(403, 'No tienes permiso para acceder a esta área.');
    }
}