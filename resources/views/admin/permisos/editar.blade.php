@extends('adminlte::page')

@section('title', 'Editar Permisos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Editar Permisos: <span class="text-primary">{{ $role->name }}</span></h1>
        <a href="{{ route('admin.permisos') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Selecciona los permisos para este rol</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.permisos.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    @foreach($permissions as $permiso)
                        <div class="col-md-3">
                            <div class="form-check mb-2">
                                <input type="checkbox" 
                                       name="permissions[]" 
                                       value="{{ $permiso->name }}"
                                       id="perm_{{ $permiso->id }}"
                                       class="form-check-input"
                                       {{ in_array($permiso->name, $rolePermissions) ? 'checked' : '' }}>
                                <label for="perm_{{ $permiso->id }}" class="form-check-label">
                                    {{ $permiso->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Permisos
                    </button>
                    <a href="{{ route('admin.permisos') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop