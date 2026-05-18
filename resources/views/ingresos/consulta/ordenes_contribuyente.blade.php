@extends('layouts.ingresos')

@section('title', 'Órdenes de cobro')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4><i class="fas fa-file-invoice-dollar"></i> Órdenes de cobro</h4>
    </div>
    <div class="card-body">
        <h5>Contribuyente: <strong>{{ $contribuyente->nombre }} {{ $contribuyente->apellido_paterno }}</strong></h5>
        <hr>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th>Área</th>
                        <th colspan="2" class="text-center">Orden de cobro</th>
                        <th colspan="2" class="text-center">Cotización</th>
                        <th>Fecha</th>
                    </tr>
                    <tr class="bg-secondary text-white">
                        <th></th>
                        <th class="text-center" style="width: 80px">Ver</th>
                        <th class="text-center" style="width: 80px">Descargar</th>
                        <th class="text-center" style="width: 80px">Ver</th>
                        <th class="text-center" style="width: 80px">Descargar</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ordenes as $orden)
                    <tr>
                        <td>
                            @if($orden->area_id == 1)
                                <span class="badge badge-info">Industria</span>
                            @elseif($orden->area_id == 2)
                                <span class="badge badge-success">Desarrollo</span>
                            @elseif($orden->area_id == 3)
                                <span class="badge badge-warning">Protección</span>
                            @endif
                        </td>
                        
                        {{-- ORDEN DE COBRO --}}
                        <td class="text-center">
                            @if($orden->orden_cobro_exists)
                                <a href="{{ route('ingresos.orden.cobro.ver', ['id' => $orden->id, 'tipo' => 'orden']) }}" target="_blank" class="btn btn-sm btn-primary" title="Ver PDF">
                                    <i class="fas fa-eye"></i>
                                </a>
                            @else
                                <span class="badge badge-secondary">—</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($orden->orden_cobro_exists)
                                <a href="{{ route('ingresos.orden.cobro.descargar', ['id' => $orden->id, 'tipo' => 'orden']) }}" class="btn btn-sm btn-success" title="Descargar PDF">
                                    <i class="fas fa-download"></i>
                                </a>
                            @else
                                <span class="badge badge-secondary">—</span>
                            @endif
                        </td>
                        
                        {{-- COTIZACIÓN --}}
                        <td class="text-center">
                            @if($orden->cotizacion_exists)
                                <a href="{{ route('ingresos.orden.cobro.ver', ['id' => $orden->id, 'tipo' => 'cotizacion']) }}" target="_blank" class="btn btn-sm btn-primary" title="Ver PDF">
                                    <i class="fas fa-eye"></i>
                                </a>
                            @else
                                <span class="badge badge-secondary">—</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($orden->cotizacion_exists)
                                <a href="{{ route('ingresos.orden.cobro.descargar', ['id' => $orden->id, 'tipo' => 'cotizacion']) }}" class="btn btn-sm btn-success" title="Descargar PDF">
                                    <i class="fas fa-download"></i>
                                </a>
                            @else
                                <span class="badge badge-secondary">—</span>
                            @endif
                        </td>
                        
                        <td class="text-center">{{ $orden->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay órdenes de cobro para este contribuyente</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            <a href="{{ route('ingresos.consultar') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>
</div>
@endsection