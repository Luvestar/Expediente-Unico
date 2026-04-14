<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña - Expediente Único</title>
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
        .forgot-link {
            text-align: center;
            margin-top: 15px;
        }
        .forgot-link a {
            color: var(--ocre-dorado);
            text-decoration: none;
        }
        .forgot-link a:hover {
            text-decoration: underline;
        }
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <img src="{{ asset('images/Logo_Tepeaca.webp') }}" alt="Logo">
                    <h4>Recuperar contraseña</h4>
                    <small>H. Ayuntamiento de Tepeaca 2024-2027</small>
                </div>
                <div class="card-body p-4">
                    @if(session('status'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> {{ session('status') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                        </div>
                    @endif

                    <p class="text-muted mb-4">
                        Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
                    </p>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email">Correo electrónico</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" name="email" id="email" class="form-control" 
                                       placeholder="admin@expedienteunico.com" required autofocus>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Enviar enlace de recuperación
                        </button>

                        <div class="forgot-link">
                            <a href="{{ route('login') }}">
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