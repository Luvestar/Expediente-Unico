@extends('adminlte::page')

@section('title', 'Administrar Usuarios')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Administrar Usuario</h1>
        <small class="text-muted">HACER EQUIPO SERVIR A TEPEACA</small>
    </div>
@stop

@section('content')
    <!-- Tarjetas de estadísticas -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalUsuarios }}</h3>
                    <p>Total de Usuarios</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $activos }}</h3>
                    <p>Activos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $inactivos }}</h3>
                    <p>Inactivos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-slash"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $administrativos }}</h3>
                    <p>Administrativos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Búsqueda -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Buscador</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.usuarios') }}" method="GET" id="buscar-form">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Buscar por nombre, apellidos, usuario o correo</label>
                            <div class="input-group">
                                <input type="text" 
                                       name="search" 
                                       class="form-control" 
                                       placeholder="Ingrese término de búsqueda..."
                                       value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Tabla de usuarios con paginación -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Usuarios registrados ({{ $usuarios->total() }})</h3>
            <div class="card-tools">
                <a href="{{ route('admin.usuarios.crear') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-user-plus"></i> Nuevo Usuario
                </a>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Área</th>
                        <th>Estado</th>
                        <th>Último acceso</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                    <tr>
                        <td>
                            <strong>{{ $usuario->nombre_completo ?? $usuario->name }}</strong>
                            <br>
                            <small class="text-muted">{{ $usuario->email }}</small>
                            @if($usuario->telefono)
                                <br>
                                <small class="text-muted">{{ $usuario->telefono }}</small>
                            @endif
                        </td>
                        <td>
                            @if($usuario->rol == 'Administrador general')
                                <span class="badge badge-danger">Administrador general</span>
                            @elseif($usuario->rol == 'Administrador de área')
                                <span class="badge badge-warning">Administrador de área</span>
                            @elseif($usuario->rol == 'Jefe de área')
                                <span class="badge badge-info">Jefe de área</span>
                            @else
                                <span class="badge badge-secondary">Usuario</span>
                            @endif
                        </td>
                        <td>
                            {{ $usuario->area->nombre ?? 'Todas' }}
                        </td>
                        <td>
                            @if($usuario->activo)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            @if($usuario->last_login_at)
                                {{ \Carbon\Carbon::parse($usuario->last_login_at)->format('d/m/Y H:i') }}
                            @else
                                <span class="text-muted">Nunca</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.usuarios.editar', $usuario->id) }}" 
                                   class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" 
                                      method="POST" style="display: inline;"
                                      onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                
                                @if($usuario->activo)
                                    <form action="{{ route('admin.usuarios.toggle', $usuario->id) }}" 
                                          method="POST" style="display: inline;"
                                          onsubmit="return confirm('¿Desactivar este usuario?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-secondary btn-sm" title="Desactivar">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.usuarios.toggle', $usuario->id) }}" 
                                          method="POST" style="display: inline;"
                                          onsubmit="return confirm('¿Activar este usuario?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm" title="Activar">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted"></i>
                            <p class="mt-2">No hay usuarios registrados</p>
                            <a href="{{ route('admin.usuarios.crear') }}" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> Agregar primer usuario
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- PAGINACIÓN -->
        <div class="card-footer clearfix">
            <div class="d-flex justify-content-center">
                {{ $usuarios->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .table td {
            vertical-align: middle;
        }
        .btn-group .btn {
            margin: 0 2px;
        }
        .pagination {
            margin-bottom: 0;
        }
    </style>
@stop