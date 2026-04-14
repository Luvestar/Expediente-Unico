<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;

class UpdateLastLoginAt
{
    public function handle(Login $event)
    {
        $user = $event->user;
        
        // Solo registrar si el usuario está activo
        if ($user->activo) {
            // Actualizar la fecha y hora del último acceso
            $user->update(['last_login_at' => Carbon::now()]);
            
            // Registrar en log por seguridad
            Log::info('Inicio de sesión registrado', [
                'user_id' => $user->id,
                'nombre' => $user->nombre_completo ?? $user->name,
                'email' => $user->email,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'fecha' => Carbon::now()->toDateTimeString()
            ]);
        }
    }
}