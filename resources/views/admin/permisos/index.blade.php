@extends('adminlte::page')

@section('title', 'Permisos y Roles')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-lock"></i> Permisos y Roles</h1>
        <small class="text-muted">Administración de accesos</small>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <i class="icon fas fa-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @foreach($roles as $rol)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                {{-- Header del rol --}}
                <div class="card-header 
                    @if($rol->name == 'Administrador general') bg-danger
                    @elseif($rol->name == 'Administrador de área') bg-warning
                    @elseif($rol->name == 'Jefe de área') bg-info
                    @else bg-secondary @endif text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas 
                                @if($rol->name == 'Administrador general') fa-crown
                                @elseif($rol->name == 'Administrador de área') fa-building
                                @elseif($rol->name == 'Jefe de área') fa-user-tie
                                @else fa-user @endif fa-lg mr-2"></i>
                            <strong>{{ $rol->name }}</strong>
                        </div>
                        <a href="{{ route('admin.permisos.editar', $rol->id) }}" class="btn btn-sm btn-light" title="Editar permisos">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    {{-- Resumen de permisos --}}
                    <div class="mb-3">
                        <span class="badge badge-primary">{{ $rol->permissions->count() }} permisos asignados</span>
                    </div>

                    {{-- Lista de permisos --}}
                    <div class="permisos-lista" style="max-height: 300px; overflow-y: auto;">
                        @forelse($rol->permissions as $permiso)
                            <span class="badge badge-light border mb-1 p-2">
                                <i class="fas fa-check-circle text-success fa-xs"></i>
                                {{ $permiso->name }}
                            </span>
                        @empty
                            <p class="text-muted text-center">Sin permisos asignados</p>
                        @endforelse
                    </div>
                </div>

                <div class="card-footer text-muted text-center small">
                    Última actualización: {{ $rol->updated_at->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Asignar rol a usuario --}}
    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-success text-white">
            <h3 class="card-title"><i class="fas fa-user-plus"></i> Asignar Rol a Usuario</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.permisos.asignar') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-5">
                        <select name="user_id" class="form-control" required>
                            <option value="">-- Seleccionar usuario --</option>
                            @foreach($usuarios as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->nombre_completo ?? $user->name }} - {{ $user->email }}
                                    ({{ $user->area->nombre ?? 'Sin área' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <select name="role" class="form-control" required>
                            <option value="">-- Seleccionar rol --</option>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-save"></i> Asignar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
<style>
    .permisos-lista {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }
    .permisos-lista .badge {
        font-size: 0.75rem;
        font-weight: normal;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        color: #495057;
    }
    .permisos-lista .badge i {
        margin-right: 4px;
    }
</style>
@stop