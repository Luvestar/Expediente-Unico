@extends('layouts.industria')

@section('title', 'Cotejar documentos')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>📋 COTEJO DE DOCUMENTOS</h4>
                </div>
                <div class="card-body">

                    <h5>Contribuyente: <strong>{{ $contribuyente->nombre }} {{ $contribuyente->apellido_paterno }}</strong></h5>
                    <hr>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="bg-secondary text-white">
                                    <th style="width: 20%">ÁREA</th>
                                    <th style="width: 50%">DOCUMENTO</th>
                                    <th style="width: 15%">ESTADO</th>
                                    <th style="width: 15%">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $areaAnterior = null;
                                    $areaCounts = [];
                                    foreach($documentos as $doc) {
                                        if(!isset($areaCounts[$doc['area']])) {
                                            $areaCounts[$doc['area']] = 0;
                                        }
                                        $areaCounts[$doc['area']]++;
                                    }
                                @endphp
                                
                                @foreach($documentos as $index => $doc)
                                    <tr>
                                        @if($doc['area'] != $areaAnterior)
                                            <td rowspan="{{ $areaCounts[$doc['area']] }}">
                                                <strong>{{ $doc['area'] }}</strong>
                                                @if($doc['subido_por'])
                                                    <span class="badge badge-secondary d-block mt-1">
                                                        Subido por: {{ App\Helpers\CotejoHelper::getNombreArea($doc['subido_por']) }}
                                                    </span>
                                                @endif
                                            </td>
                                            @php $areaAnterior = $doc['area']; @endphp
                                        @endif
                                        <td>{{ $doc['nombre'] }}</td>
                                        <td>
                                            @if($doc['estado'] == 'activo')
                                                <span class="badge badge-success">Activo</span>
                                            @else
                                                <span class="badge badge-secondary">Pendiente</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($doc['estado'] == 'activo' && $doc['ruta'])
                                                <div class="btn-group">
                                                    <a href="{{ route('industria.ver.documento', ['path' => $doc['ruta']]) }}" target="_blank" class="btn btn-sm btn-info" title="Ver">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('industria.descargar.documento', ['path' => $doc['ruta']]) }}" class="btn btn-sm btn-success" title="Descargar">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </div>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('industria.consultar') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection