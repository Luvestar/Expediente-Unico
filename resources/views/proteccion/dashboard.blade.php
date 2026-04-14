@extends('layouts.proteccion')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalTramites ?? 0 }}</h3>
                    <p>Trámites activos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <a href="{{ route('proteccion.consultar') }}" class="small-box-footer">Ver detalles <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $documentosVigentes ?? 0 }}</h3>
                    <p>Documentos Vigentes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <a href="{{ route('proteccion.vigencia') }}" class="small-box-footer">Ver detalles <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $documentosPorVencer ?? 0 }}</h3>
                    <p>Por Vencer</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="{{ route('proteccion.vigencia') }}" class="small-box-footer">Ver detalles <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    
    <!-- Últimos documentos -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Documentos recientes</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Documento</th>
                        <th>Contribuyente</th>
                        <th>Fecha</th>
                        <th>Vigencia</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ultimosDocumentos ?? [] as $doc)
                    <tr>
                        <td>{{ $doc->nombre }}</td>
                        <td>{{ $doc->contribuyente->nombre_completo ?? 'N/A' }}</td>
                        <td>{{ $doc->fecha_expedicion ? $doc->fecha_expedicion->format('d/m/Y') : 'N/A' }}</td>
                        <td>{{ $doc->fecha_vigencia ? $doc->fecha_vigencia->format('d/m/Y') : 'Indefinida' }}</td>
                        <td>
                            @if($doc->estado == 'vigente')
                                <span class="badge badge-success">Vigente</span>
                            @elseif($doc->estado == 'por_vencer')
                                <span class="badge badge-warning">Por vencer</span>
                            @elseif($doc->estado == 'vencido')
                                <span class="badge badge-danger">Vencido</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay documentos</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop