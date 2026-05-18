@extends('layouts.ingresos')

@section('title', 'Detalle de orden de cobro')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-file-invoice-dollar mr-2"></i> Detalle de orden de cobro</h4>
                        <span class="badge badge-light">{{ $orden->area_nombre }}</span>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-icon">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div class="info-box-content">
                                    <span class="info-box-text">Contribuyente</span>
                                    <span class="info-box-number">{{ $orden->contribuyente->nombre }} {{ $orden->contribuyente->apellido_paterno }}</span>
                                    <small>{{ $orden->contribuyente->nombre_empresa ?? 'Sin empresa' }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box bg-light">
                                <div class="info-box-icon">
                                    <i class="fas fa-building text-info"></i>
                                </div>
                                <div class="info-box-content">
                                    <span class="info-box-text">Área</span>
                                    <span class="info-box-number">{{ $orden->area_nombre }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box bg-light">
                                <div class="info-box-icon">
                                    <i class="fas fa-calendar-alt text-warning"></i>
                                </div>
                                <div class="info-box-content">
                                    <span class="info-box-text">Fecha de creación</span>
                                    <span class="info-box-number">{{ $orden->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="mb-0"><i class="fas fa-file-pdf mr-2"></i> Orden de cobro</h5>
                                </div>
                                <div class="card-body text-center">
                                    @if($orden->orden_cobro_exists)
                                        <div class="pdf-preview mb-3">
                                            <embed src="{{ route('ingresos.orden.cobro.ver', ['id' => $orden->id, 'tipo' => 'orden']) }}" 
                                                   type="application/pdf" 
                                                   style="width: 100%; height: 400px; border-radius: 8px;">
                                            </embed>
                                        </div>
                                        <div class="btn-group">
                                            <a href="{{ route('ingresos.orden.cobro.ver', ['id' => $orden->id, 'tipo' => 'orden']) }}" target="_blank" class="btn btn-primary">
                                                <i class="fas fa-eye"></i> Ver completo
                                            </a>
                                            <a href="{{ route('ingresos.orden.cobro.descargar', ['id' => $orden->id, 'tipo' => 'orden']) }}" class="btn btn-success">
                                                <i class="fas fa-download"></i> Descargar
                                            </a>
                                        </div>
                                    @else
                                        <div class="empty-state py-5">
                                            <i class="fas fa-file-pdf fa-4x text-muted mb-3"></i>
                                            <p class="text-muted">No hay archivo de orden de cobro</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="mb-0"><i class="fas fa-calculator mr-2"></i> Cotización</h5>
                                </div>
                                <div class="card-body text-center">
                                    @if($orden->cotizacion_exists)
                                        <div class="pdf-preview mb-3">
                                            <embed src="{{ route('ingresos.orden.cobro.ver', ['id' => $orden->id, 'tipo' => 'cotizacion']) }}" 
                                                   type="application/pdf" 
                                                   style="width: 100%; height: 400px; border-radius: 8px;">
                                            </embed>
                                        </div>
                                        <div class="btn-group">
                                            <a href="{{ route('ingresos.orden.cobro.ver', ['id' => $orden->id, 'tipo' => 'cotizacion']) }}" target="_blank" class="btn btn-primary">
                                                <i class="fas fa-eye"></i> Ver completo
                                            </a>
                                            <a href="{{ route('ingresos.orden.cobro.descargar', ['id' => $orden->id, 'tipo' => 'cotizacion']) }}" class="btn btn-success">
                                                <i class="fas fa-download"></i> Descargar
                                            </a>
                                        </div>
                                    @else
                                        <div class="empty-state py-5">
                                            <i class="fas fa-file-pdf fa-4x text-muted mb-3"></i>
                                            <p class="text-muted">No hay archivo de cotización</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12 text-right">
                            <a href="{{ route('ingresos.ordenes.cobro') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Regresar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .info-box {
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .empty-state {
        text-align: center;
        padding: 40px;
    }
</style>
@endsection