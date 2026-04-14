<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Limitar intentos: 5 intentos por minuto por IP
        $key = 'login-attempts:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => "Demasiados intentos. Intenta de nuevo en {$seconds} segundos.",
            ]);
        }

        $request->authenticate();
        
        $user = Auth::user();
        
        // Verificar si el usuario está activo
        if (!$user->activo) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return back()->withErrors(['email' => 'Tu cuenta está desactivada. Contacta al administrador.']);
        }
        
        // Limpiar contador de intentos si el login fue exitoso
        RateLimiter::clear($key);
        
        $request->session()->regenerate();
        
        // Login para Industria
        if ($user->area_id == 1) {
            if ($user->hasRole('Administrador de área') || 
                $user->hasRole('Jefe de área') || 
                $user->hasRole('Usuario')) {
                return redirect()->route('industria.estadisticas');
            }
        }
        
        // Login para Desarrollo Urbano
        if ($user->area_id == 2) {
            if ($user->hasRole('Administrador de área') || 
                $user->hasRole('Jefe de área') || 
                $user->hasRole('Usuario')) {
                return redirect()->route('desarrollo.documentos.index');
            }
        }
        
        // Login para Protección Civil
        if ($user->area_id == 3) {
            if ($user->hasRole('Administrador de área') || 
                $user->hasRole('Jefe de área') || 
                $user->hasRole('Usuario')) {
                return redirect()->route('proteccion.documentos.index');
            }
        }
        
        // Login para Ingresos
        if ($user->area_id == 4) {
            if ($user->hasRole('Administrador de área') || 
                $user->hasRole('Jefe de área') || 
                $user->hasRole('Usuario')) {
                return redirect()->route('ingresos.documentos.index');
            }
        }
        
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}