@extends('layouts.ingresos')

@section('title', 'Órdenes de cobro')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4><i class="fas fa-file-invoice-dollar"></i> Órdenes de cobro</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th>Folio</th>
                        <th>Contribuyente</th>
                        <th>Área</th>
                        <th>Orden de cobro</th>
                        <th>Cotización</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ordenes as $orden)
                    <tr>
                        <td><strong>{{ $orden->folio }}</strong></td>
                        <td>{{ $orden->contribuyente->nombre }} {{ $orden->contribuyente->apellido_paterno }}</td>
                        <td>
                            @if($orden->area_id == 1)
                                <span class="badge badge-info">Industria</span>
                            @elseif($orden->area_id == 2)
                                <span class="badge badge-success">Desarrollo</span>
                            @elseif($orden->area_id == 3)
                                <span class="badge badge-warning">Protección</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($orden->orden_cobro, 60) }}</td>
                        <td>{{ Str::limit($orden->cotizacion, 60) }}</td>
                        <td>{{ $orden->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('ingresos.orden.cobro.ver', $orden->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay órdenes de cobro registradas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection