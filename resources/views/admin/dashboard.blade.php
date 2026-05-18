@extends('adminlte::page')

@section('adminlte_css')
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>👑</text></svg>">
    @parent
@stop

@section('title', 'Dashboard Administrador')

@section('content_header')
    <h1><i class="fas fa-chart-line"></i> Dashboard Administrativo - Expediente Único</h1>
@stop

@section('content')
<script>
    const token = '{{ session('token') }}';
    if (token && token !== '') {
        sessionStorage.setItem('pestania_token', token);
        if (window.location.search.includes('token')) {
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    }
</script>
    {{-- TARJETAS GLOBALES --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalContribuyentes ?? 0 }}</h3>
                    <p>Contribuyentes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="#" class="small-box-footer">Ver detalles <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $totalTramites ?? 0 }}</h3>
                    <p>Trámites realizados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <a href="#" class="small-box-footer">Ver detalles <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalDocumentos ?? 0 }}</h3>
                    <p>Documentos subidos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <a href="#" class="small-box-footer">Ver detalles <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $totalUsuarios ?? 0 }}</h3>
                    <p>Usuarios del sistema</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-friends"></i>
                </div>
                <a href="#" class="small-box-footer">Ver detalles <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- DOCUMENTOS POR ÁREA --}}
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-2 text-primary"></i>
                        Documentos por área
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="documentosPorAreaChart" style="min-height: 250px; width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- TRÁMITES POR MES --}}
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-2 text-success"></i>
                        Trámites por mes (últimos 6 meses)
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="tramitesPorMesChart" style="min-height: 250px; width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- ACTIVIDAD RECIENTE --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-history mr-2 text-primary"></i>
                Actividad reciente en el sistema
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="bg-secondary text-white">
                            <th>Usuario</th>
                            <th>Área</th>
                            <th>Acción</th>
                            <th>Documento</th>
                            <th>Contribuyente</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($actividadReciente as $actividad)
                        <tr>
                            <td>{{ $actividad->user->name ?? 'N/A' }}</td>
                            <td>
                                @if($actividad->area_id == 1)
                                    <span class="badge badge-info">Industria</span>
                                @elseif($actividad->area_id == 2)
                                    <span class="badge badge-success">Desarrollo</span>
                                @elseif($actividad->area_id == 3)
                                    <span class="badge badge-warning">Protección</span>
                                @elseif($actividad->area_id == 4)
                                    <span class="badge badge-primary">Ingresos</span>
                                @else
                                    <span class="badge badge-secondary">N/A</span>
                                @endif
                            </td>
                            <td>{{ $actividad->accion ?? 'Registró' }}</td>
                            <td>{{ $actividad->documento_nombre ?? $actividad->tramite ?? 'N/A' }}</td>
                            <td>{{ $actividad->contribuyente->nombre ?? 'N/A' }}</td>
                            <td>{{ $actividad->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay actividad reciente</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfica de documentos por área (ahora con 4 áreas)
        const ctx1 = document.getElementById('documentosPorAreaChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json(array_keys($documentosPorArea)),
                datasets: [{
                    label: 'Documentos',
                    data: @json(array_values($documentosPorArea)),
                    backgroundColor: ['#7B1B58', '#28a745', '#ffc107', '#20c997'],
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0 }
                    }
                }
            }
        });
        
        // Gráfica de trámites por mes
        const ctx2 = document.getElementById('tramitesPorMesChart').getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: @json(array_column($tramitesPorMes, 'mes')),
                datasets: [{
                    label: 'Trámites',
                    data: @json(array_column($tramitesPorMes, 'total')),
                    backgroundColor: 'rgba(123, 27, 88, 0.2)',
                    borderColor: '#7B1B58',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#7B1B58',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0 }
                    }
                }
            }
        });
    });
</script>
@endpush