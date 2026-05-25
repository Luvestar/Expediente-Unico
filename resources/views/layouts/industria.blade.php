<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Industria y Comercio - Tepeaca</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏭</text></svg>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/tepeaca.css') }}?v={{ time() }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    @php
        $currentGuard = session('current_guard', 'industria');
        $user = Auth::guard($currentGuard)->user();
    @endphp

    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fas fa-user-circle"></i> 
                        {{ $user->nombre_completo ?? $user->name }}
                        <small class="text-muted d-block">
                            {{ $user->area->nombre ?? 'Industria y Comercio' }}
                        </small>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item"><i class="fas fa-user-circle"></i> Mi Perfil</a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('industria.estadisticas') }}" class="brand-link">
                <div class="brand-image img-circle elevation-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background-color: #ffffff;">
                    <i class="fas fa-industry" style="color: #7B1B58; font-size: 18px;"></i>
                </div>
                <span class="brand-text font-weight-light">Industria y<br>Comercio</span>
                <small class="text-muted d-block">Tepeaca</small>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info">
                        <a href="#" class="d-block">{{ $user->nombre_completo ?? $user->name }}</a>
                        <small class="text-muted">
                            @if($user->hasRole('Administrador de área'))
                                <span class="badge badge-warning">Administrador de área</span>
                            @elseif($user->hasRole('Jefe de área'))
                                <span class="badge badge-info">Jefe de área</span>
                            @else
                                <span class="badge badge-secondary">Usuario</span>
                            @endif
                        </small>
                        <div class="text-muted small mt-1">
                            <i class="fas fa-building"></i> {{ $user->area->nombre ?? 'Industria y Comercio' }}
                        </div>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <li class="nav-item">
                            <a href="{{ route('industria.estadisticas') }}" class="nav-link">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>Estadísticas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('industria.contribuyente.crear') }}" class="nav-link">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>Registrar contribuyente</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('industria.documentos.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-upload"></i>
                                <p>Agregar datos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('industria.consultar') }}" class="nav-link">
                                <i class="nav-icon fas fa-search"></i>
                                <p>Consultar información</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('industria.historial') }}" class="nav-link">
                                <i class="nav-icon fas fa-history"></i>
                                <p>Historial</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('title')</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <i class="icon fas fa-check"></i> {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <i class="icon fas fa-exclamation-triangle"></i> {{ session('error') }}
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <strong>Industria y Comercio - Tepeaca</strong>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    @stack('scripts')
</body>
</html>