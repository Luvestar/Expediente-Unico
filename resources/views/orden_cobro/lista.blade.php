@extends('layouts.ingresos')

@section('title', 'Órdenes de cobro')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-file-invoice-dollar mr-2"></i> Órdenes de cobro</h4>
                        <span class="badge badge-light">{{ $ordenes->count() }} registros</span>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="bg-secondary text-white">
                                <tr>
                                    <th>Contribuyente</th>
                                    <th>Empresa</th>
                                    <th>Área</th>
                                    <th colspan="2" class="text-center">Orden de cobro</th>
                                    <th colspan="2" class="text-center">Cotización</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                                <tr class="bg-secondary text-white">
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-center">Ver</th>
                                    <th class="text-center">Descargar</th>
                                    <th class="text-center">Ver</th>
                                    <th class="text-center">Descargar</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ordenes as $orden)
                                <tr>
                                    <td><strong>{{ $orden->contribuyente->nombre }} {{ $orden->contribuyente->apellido_paterno }}</strong></td>
                                    <td>{{ $orden->contribuyente->nombre_empresa ?? '—' }}</td>
                                    <td>
                                        @php
                                            $badgeColor = match($orden->area_id) {
                                                1 => 'info',
                                                2 => 'success',
                                                3 => 'warning',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge badge-{{ $badgeColor }}">{{ $orden->area_nombre }}</span>
                                    </td>
                                    
                                    <td class="text-center">
                                        @if($orden->orden_cobro_exists)
                                            <a href="{{ route('ingresos.orden.cobro.ver', ['id' => $orden->id, 'tipo' => 'orden']) }}" target="_blank" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @else
                                            <span class="badge badge-secondary">—</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($orden->orden_cobro_exists)
                                            <a href="{{ route('ingresos.orden.cobro.descargar', ['id' => $orden->id, 'tipo' => 'orden']) }}" class="btn btn-sm btn-success">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @else
                                            <span class="badge badge-secondary">—</span>
                                        @endif
                                    </td>
                                    
                                    <td class="text-center">
                                        @if($orden->cotizacion_exists)
                                            <a href="{{ route('ingresos.orden.cobro.ver', ['id' => $orden->id, 'tipo' => 'cotizacion']) }}" target="_blank" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @else
                                            <span class="badge badge-secondary">—</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($orden->cotizacion_exists)
                                            <a href="{{ route('ingresos.orden.cobro.descargar', ['id' => $orden->id, 'tipo' => 'cotizacion']) }}" class="btn btn-sm btn-success">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @else
                                            <span class="badge badge-secondary">—</span>
                                        @endif
                                    </tr>
                                    
                                    <td class="text-center">{{ $orden->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('ingresos.orden.cobro.show', $orden->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Detalle
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">No hay órdenes de cobro registradas</td
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection