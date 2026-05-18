@extends('layouts.ingresos')

@section('title', 'Consultar información')

@section('content')
<script>
    // Capturar token para autenticación por pestaña
    const token = '{{ session('token') }}';
    if (token && token !== '') {
        sessionStorage.setItem('pestania_token', token);
        if (window.location.search.includes('token')) {
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    }
</script>

<div class="container-fluid">
    {{-- resto del contenido --}}
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h4><i class="fas fa-search"></i> Consultar contribuyentes</h4>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('ingresos.consultar') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, RFC o empresa..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
                    @if(request('search'))
                        <a href="{{ route('ingresos.consultar') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Limpiar</a>
                    @endif
                </div>
            </div>
        </form>

        @if($resultados->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th>Nombre</th>
                            <th>Empresa</th>
                            <th>RFC</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resultados as $c)
                        <tr>
                            <td>{{ $c->nombre }} {{ $c->apellido_paterno }} {{ $c->apellido_materno }}</td>
                            <td>{{ $c->nombre_empresa ?? '—' }}</td>
                            <td>{{ $c->rfc ?? '—' }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('ingresos.consultar.expediente', $c->id) }}" class="btn btn-sm btn-info" title="Expediente">
                                        <i class="fas fa-folder-open"></i>
                                    </a>
                                    <a href="{{ route('ingresos.consultar.cotejar', $c->id) }}" class="btn btn-sm btn-success" title="Cotejar">
                                        <i class="fas fa-check-double"></i>
                                    </a>
                                    <a href="{{ route('ingresos.orden.cobro.por.contribuyente', $c->id) }}" class="btn btn-sm btn-warning" title="Ver órdenes de cobro">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- PAGINACIÓN --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $resultados->appends(request()->query())->links() }}
            </div>
        @elseif(request('search'))
            <div class="alert alert-warning">No se encontraron contribuyentes.</div>
        @else
            <div class="alert alert-info">No hay contribuyentes registrados.</div>
        @endif
    </div>
</div>
@endsection