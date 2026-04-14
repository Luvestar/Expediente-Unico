<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarRol
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        
        // Si no se especifican roles, permitir acceso a cualquier usuario autenticado
        if (empty($roles)) {
            return $next($request);
        }
        
        // Verificar si el usuario tiene el rol requerido
        foreach ($roles as $rol) {
            if ($user->rol === $rol) {
                return $next($request);
            }
        }

        // Si no tiene permiso, redirigir
        return redirect('/dashboard')->with('error', 'No tienes permiso para acceder a esta área.');
    }
}