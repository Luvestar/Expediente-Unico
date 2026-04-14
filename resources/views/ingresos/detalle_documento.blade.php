@extends('layouts.ingresos')

@section('title', 'Detalle del documento')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4>📄 Detalle del documento</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Contribuyente:</strong> {{ $documento->contribuyente->nombre_completo }}</p>
                            <p><strong>Empresa:</strong> {{ $documento->contribuyente->nombre_empresa ?? '—' }}</p>
                            <p><strong>RFC:</strong> {{ $documento->contribuyente->rfc ?? '—' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Documento:</strong> {{ $documento->nombre_documento }}</p>
                            <p><strong>Fecha de vencimiento:</strong> {{ $documento->fecha_vencimiento ? $documento->fecha_vencimiento->format('d/m/Y') : '—' }}</p>
                            <p><strong>Estado:</strong> 
                                @if($documento->estado == 'vigente')
                                    <span class="badge badge-success">Vigente</span>
                                @else
                                    <span class="badge badge-danger">Vencido</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    @if($documento->archivo_path)
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-file-pdf"></i> 
                                <a href="{{ route('ingresos.ver.pdf', ['path' => $documento->archivo_path]) }}" target="_blank" class="alert-link">
                                    Ver documento
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <a href="{{ route('ingresos.historial') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection