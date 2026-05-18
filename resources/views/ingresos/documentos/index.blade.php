@extends('layouts.ingresos')

@section('title', 'Agregar datos')

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
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4><i class="fas fa-search"></i> Buscar contribuyente</h4>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('ingresos.documentos.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, RFC, empresa o giro..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
                    @if(request('search'))
                        <a href="{{ route('ingresos.documentos.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Limpiar</a>
                    @endif
                </div>
            </div>
        </form>

        @if($contribuyentes->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th>Nombre</th>
                            <th>Empresa</th>
                            <th>RFC</th>
                            <th>Giro</th>
                            <th>Teléfono</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contribuyentes as $c)
                        <tr>
                            <td>{{ $c->nombre }} {{ $c->apellido_paterno }} {{ $c->apellido_materno }}</td>
                            <td>{{ $c->nombre_empresa ?? '—' }}</td>
                            <td>{{ $c->rfc ?? '—' }}</td>
                            <td>{{ $c->giro_comercial ?? '—' }}</td>
                            <td>{{ $c->telefono ?? '—' }}</td>
                            <td>{{ $c->tipo_persona == 'fisica' ? 'Física' : 'Moral' }}</td>
                            <td>
                                <a href="{{ route('ingresos.documentos.cargar', $c->id) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-upload"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- PAGINACIÓN --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $contribuyentes->appends(request()->query())->links() }}
            </div>
        @elseif(request('search'))
            <div class="alert alert-warning">No se encontraron contribuyentes.</div>
        @else
            <div class="alert alert-info">No hay contribuyentes registrados.</div>
        @endif
    </div>
</div>
@endsection