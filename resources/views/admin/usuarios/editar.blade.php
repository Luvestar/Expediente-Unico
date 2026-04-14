@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    <h1>Editar Usuario</h1>
@stop

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombre completo</label>
                            <input type="text"
                                   name="nombre_completo"
                                   class="form-control"
                                   value="{{ old('nombre_completo', $usuario->nombre_completo ?? $usuario->name) }}"
                                   required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   value="{{ old('email', $usuario->email) }}"
                                   required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text"
                                   name="telefono"
                                   class="form-control"
                                   value="{{ old('telefono', $usuario->telefono) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombre de usuario</label>
                            <input type="text"
                                   name="username"
                                   class="form-control"
                                   value="{{ old('username', $usuario->name) }}"
                                   required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Rol <span class="text-danger">*</span></label>
                            <select name="rol" id="rolSelect" class="form-control" required>
                                <option value="">Seleccione un rol</option>
                                <option value="Administrador general" {{ old('rol', $usuario->rol) == 'Administrador general' ? 'selected' : '' }}>Administrador general</option>
                                <option value="Administrador de área" {{ old('rol', $usuario->rol) == 'Administrador de área' ? 'selected' : '' }}>Administrador de área</option>
                                <option value="Jefe de área" {{ old('rol', $usuario->rol) == 'Jefe de área' ? 'selected' : '' }}>Jefe de área</option>
                                <option value="Usuario" {{ old('rol', $usuario->rol) == 'Usuario' ? 'selected' : '' }}>Usuario</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6" id="areaFieldContainer">
                        <div class="form-group">
                            <label for="area_id">Área <span class="text-danger">*</span></label>
                            <select name="area_id" id="area_id" class="form-control">
                                <option value="">Seleccione un área</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id }}" {{ old('area_id', $usuario->area_id) == $area->id ? 'selected' : '' }}>
                                        {{ $area->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">El área es obligatoria para roles diferentes a Administrador General.</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nueva contraseña (dejar vacío para no cambiar)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Confirmar contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                    <a href="{{ route('admin.usuarios') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rolSelect = document.getElementById('rolSelect');
        const areaFieldContainer = document.getElementById('areaFieldContainer');
        const areaSelect = document.getElementById('area_id');

        function toggleAreaField() {
            if (rolSelect.value === 'Administrador general') {
                // Si el rol es Admin General, el área no es obligatoria y se oculta
                areaFieldContainer.style.display = 'none';
                areaSelect.removeAttribute('required');
            } else {
                // Para otros roles, el área es obligatoria y se muestra
                areaFieldContainer.style.display = 'block';
                areaSelect.setAttribute('required', 'required');
            }
        }

        // Ejecutar al cargar la página para establecer el estado inicial
        toggleAreaField();

        // Ejecutar cada vez que cambie el rol
        rolSelect.addEventListener('change', toggleAreaField);
    });
</script>
@stop