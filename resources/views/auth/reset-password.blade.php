<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña - Expediente Único</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🔐</text></svg>">
    <style>
        :root {
            --morado-principal: #7B1B58;
            --morado-claro: #7A1754;
            --ocre-dorado: #C49A6C;
        }
        body {
            background: linear-gradient(135deg, var(--morado-principal), var(--morado-claro));
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border: none;
        }
        .card-header {
            background: linear-gradient(135deg, var(--morado-principal), var(--morado-claro));
            color: white;
            border-radius: 20px 20px 0 0 !important;
            text-align: center;
            padding: 25px;
        }
        .card-header img {
            max-height: 70px;
            margin-bottom: 10px;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--morado-principal), var(--morado-claro));
            border: none;
            width: 100%;
            padding: 12px;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--morado-claro), var(--morado-principal));
        }
        .form-control:focus {
            border-color: var(--ocre-dorado);
            box-shadow: 0 0 0 0.2rem rgba(196, 154, 108, 0.25);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <img src="{{ asset('images/Logo_Tepeaca.webp') }}" alt="Logo">
                    <h4>Restablecer contraseña</h4>
                    <small>H. Ayuntamiento de Tepeaca 2024-2027</small>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="form-group">
                            <label for="email">Correo electrónico</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" name="email" id="email" class="form-control" 
                                       value="{{ old('email', $request->email) }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">Nueva contraseña</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirmar contraseña</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Restablecer contraseña
                        </button>

                        <div class="forgot-link text-center mt-3">
                            <a href="{{ route('login') }}" class="text-muted">
                                <i class="fas fa-arrow-left"></i> Volver al inicio de sesión
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>