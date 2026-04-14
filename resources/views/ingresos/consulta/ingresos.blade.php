@extends('layouts.ingresos')

@section('title', 'Consultar información')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>🔍 Consultar contribuyente</h4>
                </div>
                <div class="card-body">

                    <form method="GET" action="{{ route('ingresos.consultar') }}" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, RFC, empresa o giro..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </form>

                    @if(isset($resultados) && $resultados->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr class="bg-secondary text-white">
                                        <th>Nombre</th>
                                        <th>Empresa</th>
                                        <th>RFC</th>
                                        <th>Acciones</th>
                                    </tr
                                </thead>
                                <tbody>
                                    @foreach($resultados as $c)
                                    <tr
                                        <td>{{ $c->nombre }} {{ $c->apellido_paterno }} {{ $c->apellido_materno }}</td>
                                        <td>{{ $c->nombre_empresa ?? '—' }}</td>
                                        <td>{{ $c->rfc }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('ingresos.consultar.expediente', $c->id) }}" class="btn btn-sm btn-info" title="Ver expediente">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('ingresos.consultar.cotejar', $c->id) }}" class="btn btn-sm btn-secondary" title="Cotejar documentos">
                                                    <i class="fas fa-copy"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif(request('search'))
                        <div class="alert alert-warning">No se encontraron contribuyentes.</div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection