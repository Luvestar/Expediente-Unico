@extends('layouts.desarrollo')

@section('title', 'Expediente del contribuyente')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
            {{-- DATOS DEL CONTRIBUYENTE --}}
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4><i class="fas fa-user-circle"></i> Datos del contribuyente</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-line">
                                <i class="fas fa-user text-primary"></i>
                                <strong>Nombre:</strong> {{ $contribuyente->nombre }} {{ $contribuyente->apellido_paterno }} {{ $contribuyente->apellido_materno }}
                            </div>
                            <div class="info-line">
                                <i class="fas fa-id-card text-primary"></i>
                                <strong>RFC:</strong> {{ $contribuyente->rfc ?? '—' }}
                            </div>
                            <div class="info-line">
                                <i class="fas fa-building text-primary"></i>
                                <strong>Empresa:</strong> {{ $contribuyente->nombre_empresa ?? '—' }}
                            </div>
                            <div class="info-line">
                                <i class="fas fa-chart-line text-primary"></i>
                                <strong>Giro:</strong> {{ $contribuyente->giro_comercial ?? '—' }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-line">
                                <i class="fas fa-map-marker-alt text-primary"></i>
                                <strong>Dirección:</strong> {{ $contribuyente->direccion ?? '—' }}
                            </div>
                            <div class="info-line">
                                <i class="fas fa-phone text-primary"></i>
                                <strong>Teléfono:</strong> {{ $contribuyente->telefono ?? '—' }}
                            </div>
                            <div class="info-line">
                                <i class="fas fa-envelope text-primary"></i>
                                <strong>Email:</strong> {{ $contribuyente->email ?? '—' }}
                            </div>
                            <div class="info-line">
                                <i class="fas fa-tag text-primary"></i>
                                <strong>Tipo:</strong> {{ $contribuyente->tipo_persona == 'fisica' ? 'Persona Física' : 'Persona Moral' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DOCUMENTOS POR PROCESO --}}
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4><i class="fas fa-folder-open"></i> Documentos por proceso</h4>
                </div>
                <div class="card-body">
                    
                    @forelse($tramites as $tramite)
                        <div class="card mb-3 border">
                            <div class="card-header bg-primary text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-tag"></i>
                                        <strong>{{ $tramite->tramite }}</strong>
                                    </div>
                                    <div>
                                        <i class="far fa-calendar-alt"></i>
                                        {{ $tramite->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead class="bg-secondary text-white">
                                            <tr>
                                                <th style="width: 45%"><i class="fas fa-file-alt"></i> Documento</th>
                                                <th style="width: 25%"><i class="fas fa-tag"></i> Tipo</th>
                                                <th style="width: 30%"><i class="fas fa-cogs"></i> Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($tramite->archivos && count($tramite->archivos) > 0)
                                                @foreach($tramite->archivos as $nombre => $ruta)
                                                    <tr>
                                                        <td>
                                                            <i class="fas fa-file-pdf text-danger"></i> {{ $nombre }}
                                                        </td>
                                                        <td>
                                                            @php
                                                                $tipo = 'Documento';
                                                                if(str_contains($nombre, 'ine')) $tipo = 'Identificación';
                                                                elseif(str_contains($nombre, 'rfc')) $tipo = 'Fiscal';
                                                                elseif(str_contains($nombre, 'domicilio')) $tipo = 'Domicilio';
                                                                elseif(str_contains($nombre, 'predial')) $tipo = 'Predial';
                                                                elseif(str_contains($nombre, 'agua') || str_contains($nombre, 'luz')) $tipo = 'Servicio';
                                                            @endphp
                                                            <span class="badge badge-secondary">{{ $tipo }}</span>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="{{ route('desarrollo.ver.pdf', ['path' => $ruta]) }}" target="_blank" class="btn btn-info" title="Ver PDF">
                                                                    <i class="fas fa-eye"></i> Ver
                                                                </a>
                                                                <a href="{{ route('desarrollo.descargar.documento', ['path' => $ruta]) }}" class="btn btn-success" title="Descargar">
                                                                    <i class="fas fa-download"></i> Descargar
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted">
                                                        <i class="fas fa-inbox"></i> No hay documentos en este proceso
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle"></i> No hay trámites registrados para este contribuyente.
                        </div>
                    @endforelse
                    
                </div>
            </div>

            {{-- BOTÓN REGRESAR --}}
            <div class="mt-4">
                <a href="{{ route('desarrollo.consultar') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Regresar
                </a>
            </div>

        </div>
    </div>
</div>

<style>
.info-line {
    margin-bottom: 12px;
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}
.info-line:last-child {
    border-bottom: none;
    margin-bottom: 0;
}
.info-line i {
    width: 25px;
    margin-right: 10px;
}
.info-line strong {
    display: inline-block;
    width: 80px;
}
.card {
    border-radius: 12px;
    overflow: hidden;
}
.table td, .table th {
    padding: 12px 15px;
    vertical-align: middle;
}
.btn-group .btn {
    margin: 0 3px;
    border-radius: 6px;
}
.badge {
    font-size: 0.75rem;
    padding: 5px 10px;
    border-radius: 20px;
}
</style>
@endsection