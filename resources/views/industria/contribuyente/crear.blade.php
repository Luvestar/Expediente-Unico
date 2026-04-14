@extends('layouts.industria')

@section('title', 'Registrar Contribuyente')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Alta de Nuevo Contribuyente</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <i class="icon fas fa-check"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Errores:</h5>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('industria.contribuyente.guardar') }}" method="POST">
                        @csrf

                        <!-- Datos del Contribuyente -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Datos del Contribuyente</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombre">Nombre(s) <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control @error('nombre') is-invalid @enderror" 
                                                   id="nombre" 
                                                   name="nombre" 
                                                   value="{{ old('nombre') }}"
                                                   placeholder="Ingrese nombre(s)"
                                                   required>
                                        </div>
                                    </div>
                                    {{-- En lugar de "apellidos", usa dos campos --}}
<div class="col-md-6">
    <label>Apellido Paterno *</label>
    <input type="text" name="apellido_paterno" class="form-control" required value="{{ old('apellido_paterno') }}">
</div>
<div class="col-md-6">
    <label>Apellido Materno</label>
    <input type="text" name="apellido_materno" class="form-control" value="{{ old('apellido_materno') }}">
</div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rfc">RFC <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control @error('rfc') is-invalid @enderror" 
                                                   id="rfc" 
                                                   name="rfc" 
                                                   value="{{ old('rfc') }}"
                                                   placeholder="RFC del contribuyente"
                                                   maxlength="13"
                                                   required>
                                            <small class="text-muted">13 caracteres (ej: ABCD123456XYZ)</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="telefono">Teléfono</label>
                                            <input type="text" 
                                                   class="form-control @error('telefono') is-invalid @enderror" 
                                                   id="telefono" 
                                                   name="telefono" 
                                                   value="{{ old('telefono') }}"
                                                   placeholder="222-000-0000">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Correo electrónico</label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}"
                                           placeholder="correo@ejemplo.com">
                                </div>
                            </div>
                        </div>

                        <!-- Datos de la Empresa -->
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Datos de la Empresa</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombre_empresa">Nombre del comercio o empresa <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control @error('nombre_empresa') is-invalid @enderror" 
                                                   id="nombre_empresa" 
                                                   name="nombre_empresa" 
                                                   value="{{ old('nombre_empresa') }}"
                                                   placeholder="Nombre comercial"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="giro_comercial">Giro Comercial <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control @error('giro_comercial') is-invalid @enderror" 
                                                   id="giro_comercial" 
                                                   name="giro_comercial" 
                                                   value="{{ old('giro_comercial') }}"
                                                   placeholder="Ej: Alimentos, Farmacia, Taller mecánico, etc."
                                                   required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="direccion">Dirección del Comercio <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                              id="direccion" 
                                              name="direccion" 
                                              rows="3" 
                                              placeholder="Calle, número, colonia, Tepeaca"
                                              required>{{ old('direccion') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Tipo de Persona <span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="radio" 
                                                       name="tipo_persona" 
                                                       id="fisica" 
                                                       value="fisica" 
                                                       {{ old('tipo_persona', 'fisica') == 'fisica' ? 'checked' : '' }}
                                                       required>
                                                <label class="form-check-label" for="fisica">
                                                    Persona Física
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="radio" 
                                                       name="tipo_persona" 
                                                       id="moral" 
                                                       value="moral"
                                                       {{ old('tipo_persona') == 'moral' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="moral">
                                                    Persona Moral
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary float-right">
                                    <i class="fas fa-save"></i> Registrar Contribuyente
                                </button>
                                <a href="{{ route('industria.contribuyentes') }}" class="btn btn-secondary float-right mr-2">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
@stop

@section('js')
<script>
    // Validación de RFC (formato básico)
    document.getElementById('rfc').addEventListener('input', function(e) {
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
    });

    // Validación de teléfono (solo números y guiones)
    document.getElementById('telefono').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9-]/g, '');
    });
</script>
@stop