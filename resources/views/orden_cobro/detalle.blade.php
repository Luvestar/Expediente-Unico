@extends('layouts.ingresos')

@section('title', 'Detalle de orden de cobro')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4><i class="fas fa-file-invoice-dollar"></i> Detalle de orden de cobro</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Folio:</strong> {{ $orden->folio }}</p>
                <p><strong>Contribuyente:</strong> {{ $orden->contribuyente->nombre }} {{ $orden->contribuyente->apellido_paterno }}</p>
                <p><strong>Área:</strong> 
                    @if($orden->area_id == 1)
                        Industria y Comercio
                    @elseif($orden->area_id == 2)
                        Desarrollo Urbano
                    @elseif($orden->area_id == 3)
                        Protección Civil
                    @endif
                </p>
                <p><strong>Fecha:</strong> {{ $orden->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Última actualización:</strong> {{ $orden->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5><i class="fas fa-file-alt"></i> Orden de cobro</h5>
                    </div>
                    <div class="card-body">
                        {{ nl2br(e($orden->orden_cobro)) }}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5><i class="fas fa-calculator"></i> Cotización</h5>
                    </div>
                    <div class="card-body">
                        {{ nl2br(e($orden->cotizacion)) }}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-right mt-4">
            <a href="{{ route('ingresos.ordenes.cobro') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>
</div>
@endsection