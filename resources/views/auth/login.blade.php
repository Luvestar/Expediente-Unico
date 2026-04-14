<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expediente Único - Iniciar sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🔐</text></svg>">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Variables de colores institucionales */
        :root {
            --morado-principal: #7B1B58;
            --morado-claro: #7A1754;
            --morado-oscuro: #5A1240;
            --ocre-dorado: #C49A6C;
            --ocre-claro: #D4B08C;
            --ocre-oscuro: #A87D4F;
        }
        
        body {
            background-image: url('{{ asset('images/fondo-tepeaca.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            position: relative;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* Overlay con gradiente institucional */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(123, 27, 88, 0.85), rgba(0, 0, 0, 0.6));
            z-index: 1;
        }
        
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
            padding: 20px;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.96);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 420px;
            overflow: hidden;
            animation: fadeInUp 0.6s ease;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--morado-principal), var(--morado-claro));
            text-align: center;
            padding: 30px 20px;
            border-bottom: 3px solid var(--ocre-dorado);
        }
        
        .login-header img {
            max-height: 90px;
            margin-bottom: 15px;
        }
        
        .login-header h4 {
            color: white;
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        
        .login-header small {
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            display: block;
            margin-top: 5px;
        }
        
        .login-body {
            padding: 35px 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }
        
        .input-group-text {
            background: #f0f0f0;
            border: 1px solid #ddd;
            border-right: none;
            color: var(--morado-principal);
        }
        
        .form-control {
            border-left: none;
            padding: 12px 15px;
            font-size: 14px;
        }
        
        .form-control:focus {
            border-color: var(--ocre-dorado);
            box-shadow: 0 0 0 0.2rem rgba(196, 154, 108, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--morado-principal), var(--morado-claro));
            color: white;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn-login:hover {
            background: linear-gradient(135deg, var(--morado-claro), var(--morado-oscuro));
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(123, 27, 88, 0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .checkbox-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 20px 0;
        }
        
        .checkbox-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            color: #555;
            font-size: 14px;
        }
        
        .checkbox-label input {
            margin-right: 8px;
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: var(--ocre-dorado);
        }
        
        .forgot-link a {
            color: var(--ocre-dorado);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }
        
        .forgot-link a:hover {
            color: var(--morado-principal);
            text-decoration: underline;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 12px;
            font-size: 14px;
        }
        
        .alert-danger i {
            margin-right: 8px;
        }
        
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 12px;
            font-size: 14px;
        }
        
        .alert-success i {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <img src="{{ asset('images/Logo_Tepeaca.webp') }}" alt="Logo H. Ayuntamiento de Tepeaca">
                <h4>Expediente Único</h4>
                <small>H. Ayuntamiento de Tepeaca 2024-2027</small>
            </div>
            <div class="login-body">
                <!-- Session Status -->
                @if(session('status'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('status') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> 
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                            <input id="email" type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="usuario@tepeaca.com"
                                   required autofocus autocomplete="username">
                        </div>
                        @error('email')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </div>
                            <input id="password" type="password" 
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password"
                                   placeholder="••••••••"
                                   required autocomplete="current-password">
                        </div>
                        @error('password')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="checkbox-container">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            Recordarme
                        </label>

                        @if (Route::has('password.request'))
                            <div class="forgot-link">
                                <a href="{{ route('password.request') }}">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i> Iniciar sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>