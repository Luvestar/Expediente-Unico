@extends('adminlte::page')

@section('title', 'Configuración')

@section('content_header')
    <h1><i class="fas fa-cog"></i> Configuración del Sistema</h1>
@stop

@section('content')
    {{-- Mensajes de éxito/error --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
        </div>
    @endif

    <div class="row">
        {{-- CONFIGURACIÓN GENERAL --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-globe mr-2 text-primary"></i>
                        Configuración General
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.configuracion.general') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label>Nombre del sistema</label>
                            <input type="text" name="nombre_sistema" class="form-control" 
                                   value="{{ $configuracionGeneral['nombre_sistema'] }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Logo</label>
                            <input type="file" name="logo" class="form-control-file" accept="image/*">
                            @if($configuracionGeneral['logo'])
                                <small class="text-muted">Logo actual: {{ $configuracionGeneral['logo'] }}</small>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label>Tema</label>
                            <select name="tema" class="form-control">
                                <option value="claro" {{ $configuracionGeneral['tema'] == 'claro' ? 'selected' : '' }}>Claro</option>
                                <option value="oscuro" {{ $configuracionGeneral['tema'] == 'oscuro' ? 'selected' : '' }}>Oscuro</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar configuración
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- VIGENCIAS POR DEFECTO --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-calendar-alt mr-2 text-warning"></i>
                Vigencias por defecto (días)
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.configuracion.vigencias') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>INE</label>
                            <input type="number" name="vigencia_ine" class="form-control" 
                                   value="{{ $vigencias['INE'] }}" required>
                            <small class="text-muted">Días de vigencia</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>RFC</label>
                            <input type="number" name="vigencia_rfc" class="form-control" 
                                   value="{{ $vigencias['RFC'] }}" required>
                            <small class="text-muted">Días de vigencia</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>CURP</label>
                            <input type="number" name="vigencia_curp" class="form-control" 
                                   value="{{ $vigencias['CURP'] ?? 3650 }}" required>
                            <small class="text-muted">Días de vigencia</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Comprobante domicilio (Luz)</label>
                            <input type="number" name="vigencia_luz" class="form-control" 
                                   value="{{ $vigencias['Comprobante domicilio (Luz)'] }}" required>
                            <small class="text-muted">Días de vigencia</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Comprobante domicilio (Agua)</label>
                            <input type="number" name="vigencia_agua" class="form-control" 
                                   value="{{ $vigencias['Comprobante domicilio (Agua)'] }}" required>
                            <small class="text-muted">Días de vigencia</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Comprobante predial</label>
                            <input type="number" name="vigencia_predial" class="form-control" 
                                   value="{{ $vigencias['Comprobante predial'] }}" required>
                            <small class="text-muted">Días de vigencia</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Licencia/Cédula</label>
                            <input type="number" name="vigencia_licencia" class="form-control" 
                                   value="{{ $vigencias['Licencia/Cédula'] }}" required>
                            <small class="text-muted">Días de vigencia</small>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar vigencias
                </button>
            </form>
        </div>
    </div>
@endsection