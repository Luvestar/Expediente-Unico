@extends('layouts.industria')

@section('title', 'Estadísticas')

@section('content')
<script>
    // Capturar token de la sesión flash (para autenticación por pestaña)
    const token = '{{ session('token') }}';
    if (token && token !== '') {
        sessionStorage.setItem('pestania_token', token);
        // Limpiar la URL si viene con token
        if (window.location.search.includes('token')) {
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    }
</script>

<div class="container-fluid">
    {{-- TARJETAS DE RESUMEN --}}
    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalContribuyentes ?? 0 }}</h3>
                    <p>Contribuyentes registrados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('industria.consultar') }}" class="small-box-footer">
                    Ver detalles <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalTramites ?? 0 }}</h3>
                    <p>Trámites realizados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <a href="{{ route('industria.historial') }}" class="small-box-footer">
                    Ver detalles <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-4 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $totalDocumentos ?? 0 }}</h3>
                    <p>Documentos subidos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <a href="{{ route('industria.historial') }}" class="small-box-footer">
                    Ver detalles <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- GRÁFICA DE TRÁMITES POR MES --}}
    <div class="card">
        <div class="card-header border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar mr-2 text-primary"></i>
                    Trámites por mes
                </h3>
            </div>
        </div>
        <div class="card-body">
            <canvas id="tramitesChart" style="min-height: 300px; width: 100%;"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('tramitesChart').getContext('2d');
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($meses),
                datasets: [{
                    label: 'Trámites',
                    data: @json($totales),
                    backgroundColor: 'rgba(123, 27, 88, 0.7)',
                    borderColor: '#7B1B58',
                    borderWidth: 1,
                    borderRadius: 8,
                    barPercentage: 0.7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.raw} trámite${context.raw !== 1 ? 's' : ''}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        },
                        title: {
                            display: true,
                            text: 'Cantidad de trámites'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Mes'
                        }
                    }
                }
            }
        });
    });
</script>
@endpush