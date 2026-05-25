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
    public function create(Request $request, $guard = null): View
    {
        if (!$guard) {
            $guard = $request->query('guard', 'web');
        }
        
        return view('auth.login', compact('guard'));
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $guard = $request->input('guard', 'web');
        
        $key = 'login-attempts:' . $request->ip() . ':' . $guard;
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => "Demasiados intentos. Intenta de nuevo en {$seconds} segundos.",
            ]);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');
        
        if (Auth::guard($guard)->attempt($credentials, $remember)) {
            $user = Auth::guard($guard)->user();
            
            if (!$user->activo) {
                Auth::guard($guard)->logout();
                RateLimiter::hit($key, 60);
                return back()->withErrors(['email' => 'Tu cuenta está desactivada.']);
            }
            
            $accessValidation = $this->validateUserAccess($user, $guard);
            
            if (!$accessValidation['allowed']) {
                Auth::guard($guard)->logout();
                RateLimiter::hit($key, 60);
                return back()->withErrors(['email' => $accessValidation['message']]);
            }
            
            RateLimiter::clear($key);
            $request->session()->regenerate();
            $request->session()->put('current_guard', $guard);
            
            return $this->redirectByGuard($user, $guard);
        }
        
        RateLimiter::hit($key, 60);
        
        throw ValidationException::withMessages([
            'email' => 'Las credenciales no coinciden.',
        ]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $guard = $request->session()->get('current_guard', 'web');
        
        Auth::guard($guard)->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login', ['guard' => $guard]);
    }
    
    private function validateUserAccess($user, string $guard): array
    {
        switch ($guard) {
            case 'admin':
                return [
                    'allowed' => ($user->rol === 'Administrador general'),
                    'message' => 'No tienes permisos de administrador.'
                ];
                
            case 'industria':
                return [
                    'allowed' => ($user->area_id == 1 && in_array($user->rol, ['Administrador de área', 'Jefe de área', 'Usuario'])),
                    'message' => 'No perteneces al área de Industria.'
                ];
                
            case 'desarrollo':
                return [
                    'allowed' => ($user->area_id == 2 && in_array($user->rol, ['Administrador de área', 'Jefe de área', 'Usuario'])),
                    'message' => 'No perteneces al área de Desarrollo Urbano.'
                ];
                
            case 'proteccion':
                return [
                    'allowed' => ($user->area_id == 3 && in_array($user->rol, ['Administrador de área', 'Jefe de área', 'Usuario'])),
                    'message' => 'No perteneces al área de Protección Civil.'
                ];
                
            case 'ingresos':
                return [
                    'allowed' => ($user->area_id == 4 && in_array($user->rol, ['Administrador de área', 'Jefe de área', 'Usuario'])),
                    'message' => 'No perteneces al área de Ingresos.'
                ];
                
            default:
                return ['allowed' => true, 'message' => ''];
        }
    }
    
    private function redirectByGuard($user, string $guard): RedirectResponse
    {
        switch ($guard) {
            case 'admin':
                return redirect()->intended(route('admin.usuarios'));
                
            case 'industria':
                return redirect()->intended(route('industria.estadisticas'));
                
            case 'desarrollo':
                return redirect()->intended(route('desarrollo.documentos.index'));
                
            case 'proteccion':
                return redirect()->intended(route('proteccion.documentos.index'));
                
            case 'ingresos':
                return redirect()->intended(route('ingresos.documentos.index'));
                
            default:
                return redirect()->intended(route('admin.usuarios'));
        }
    }
}